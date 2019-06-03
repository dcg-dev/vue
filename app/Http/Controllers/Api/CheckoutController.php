<?php

namespace App\Http\Controllers\Api;

use App\Facades\PayPalPayment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Item;
use App\Models\License;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\CompleteOrder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\App;

trait CheckoutController
{

    use RegistersUsers;

    /**
     * Return all items in checkout
     *
     * @return array
     */
    public function checkoutInfo()
    {
        $items = [];
        $subtotal = 0;
        $vat = $this->user() && $this->user()->country_info ? 1 - $this->user()->country_info->vat / 100 : 1;
        foreach (Cart::getContent() as $item) {
            if ($currentItem = Item::with('creator.country_info')->find($item->id)) {
                $subtotal += $vat * $item->price;
                $items[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'attributes' => $currentItem
                ];
            }
        }
        $total = round(Cart::getTotal(), 2);
        $vatTotal = round($total - $subtotal, 2);
        return ['items' => $items,
            'subtotal' => round($subtotal, 2),
            'vat' => [
                'percentage' => !$vatTotal || !$total ? 0 : round(($vatTotal / $total) * 100, 2),
                'total' => $vatTotal,
            ],
            'total' => $total
        ];
    }

    /**
     * Add item to cart
     *
     * @param Request $request
     *
     * @return Cart
     */
    public function addItem(Request $request)
    {
        if (!Cart::get($request->get('itemId'))) {
            $item = Item::findOrFail($request->get('itemId'));
            if ($item->licenses()->pluck('licenses.id')->contains($request->get('licenseId'))) {
                $license = License::findOrFail($request->get('licenseId'));
                if ($license->enabled) {
                    Cart::add([
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => !$license->coefficient ? $item->price : round($license->coefficient * $item->price, 2),
                        'quantity' => 1,
                        'attributes' => [
                            'license_id' => $request->get('licenseId')
                        ]
                    ]);
                    return [
                        'status' => true
                    ];
                } else {
                    throw new \Exception("The licence is disabled.");
                }
            } else {
                throw new \Exception("The license couldn't be recognized for current item.");
            }
        } else {
            throw new \Exception("Current item is alredy in the cart, check the cart out!");
        }
    }

    /**
     * Remove item to cart
     *
     * @param Item $item
     *
     * @return array
     */
    public function removeItem(Item $item)
    {
        return [
            'status' => Cart::remove($item->id)
        ];
    }

    /**
     * Complete order
     *
     * @param CompleteOrder $request
     *
     * @return array
     */
    public function complete(CompleteOrder $request)
    {
        if (count(Cart::getContent())) {
            if ($this->user()) {
                $result = $this->createOrder($this->user(), $request);
            } else {
                $user = User::create([
                    'username' => $request->get('username'),
                    'email' => $request->get('email'),
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                    'country' => $request->get('country'),
                    'city' => $request->get('city'),
                    'password' => bcrypt($request->get('password'))
                ]);
                event(new Registered($user));
                $this->guard()->login($user);
                $result = $this->createOrder($user, $request);
            }
        } else {
            throw new \Exception("The cart is empty.");
        }
        return $result;
    }

    /**
     * Create new order
     *
     * @param User $user
     * @param CompleteOrder $request
     *
     * @return array
     */
    public function createOrder(User $user, CompleteOrder $request)
    {
        switch ($request->get('payment_type')) {
            case "stripe":
                if ($this->possibleStripe()) {
                    $this->checkStripeCustomer($user, $request->get('token'));
                    $order = $this->createCheckoutOrder($user, $request->get('payment_type'));
                    $this->makePayment($user, $order);
                    Cart::clear();
                    return ['status' => true];
                } else {
                    throw new \Exception("Current order couldn't be paid by Stripe gateway.");
                }
                break;
            case "paypal":
                if ($this->possiblePayPal()) {
                    $order = $this->createCheckoutOrder($user, $request->get('payment_type'));
                    $result = PayPalPayment::makePayment($order);
                    Cart::clear();
                    return array_merge(['status' => true], $result);
                } else {
                    throw new \Exception("Current order couldn't be paid by PayPal gateway.");
                }
                break;
            default:
                throw new \Exception("Payment type is unsupported.");
        }
    }

    /**
     * Create order for checkout
     *
     * @param User $user
     * @param string $paymentType
     *
     * @return array
     */
    public function createCheckoutOrder(User $user, $paymentType)
    {
        $order = Order::create([
            'customer_id' => $user->id,
            'amount' => round(Cart::getTotal(), 2),
            'payment_type' => $paymentType,
            'order_status' => 'pending'
        ]);
        foreach (Cart::getContent() as $item) {
            $merchantUser = User::find(Item::findOrFail($item->id)->creator_id);
            $merchantPlan = Plan::where('stripe_id', $merchantUser->subscription('main')->stripe_plan)->first();
            $commissionAmount = number_format($item->price * $merchantPlan->commission / 100, 2);
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item->id,
                'license_id' => $item->attributes->license_id,
                'price' => $item->price,
                'commission_amount' => $commissionAmount
            ]);
        }
        return $order;
    }

}
