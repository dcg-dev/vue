<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plan;
use Stripe\Charge as StripeCharge;
use Stripe\Token as StripeToken;

trait StripeController {
    
    /**
     * Make payment for order
     * 
     * @param User $user
     * @param Order $order
     *
     * @return void
     */
    public function makePayment(User $user, Order $order) {
        $itemStatuses = [];
        //for all merchants
        foreach(Cart::getContent() as $item) {
            $itemStatuses[] = $this->chargeToMerchant($user, $item, $order);
        }
        
        if (count(array_keys($itemStatuses, "paid")) == count(Cart::getContent())) {
           $order->order_status = 'paid';
        }
        $order->save();
    }

    /**
     * Create new charge
     * 
     * @param User $user
     * @param float $amount
     * @param User $merchant
     * @param float $commission
     *
     * @return void
     */
    public function createStripeCharge(User $user, $amount, $merchant, $commission) {
//        $merchantPlan = Plan::where('stripe_id', $this->user()->subscription('main')->stripe_plan)->first();
        $centsAmount = (int)($amount * 100); //from dollars to cents
//        $applicationFee = (int)($centsAmount * $merchantPlan->commission / 100);
        $applicationFee = $commission * 100;

        //sharing customer with another account
        $token = StripeToken::create(["customer" => $user->stripe_id],
                                     ["stripe_account" => $merchant->stripe_account_id]);

        $params = [
            'currency' => 'usd',
            'amount' => $centsAmount,
            'source' => $token->id,
            'application_fee' => $applicationFee
        ];
        $options = [
            'api_key' => $user->getStripeKey(),
            'stripe_account' => $merchant->stripe_account_id
        ];

        return ['fee_amount' => $applicationFee, 'stripe_charge' => StripeCharge::create($params, $options)];
    }
    
    /**
     * Check if possible to make payment by Stripe gateway
     *
     * @param User $user
     * 
     * @return bool
     */
    public function possibleStripe() {
        foreach(Cart::getContent() as $item) {
            $currentItem = Item::findOrFail($item->id);
            $currentUser = User::findOrFail($currentItem->creator_id);
            if (!$currentUser->hasStripeSubscription() || !$currentUser->stripe_account_id) {
                return false;
            }
        } 
        return true;
    }
    
    /**
     * Check if possible to make a payment by Stripe gateway
     * 
     * @param User $user
     * @param mixed $checkoutItem
     * @param Order $order
     *
     * @return void
     */
    public function chargeToMerchant(User $user, $checkoutItem, Order $order) {
        $merchantItem = Item::findOrFail($checkoutItem->id);
        $merchant = User::findOrFail($merchantItem->creator_id);
        $orderItem = OrderItem::where([['order_id', '=', $order->id], ['item_id', '=', $checkoutItem->id]])->first();
        $chargeArray = $this->createStripeCharge($user, $checkoutItem->price, $merchant, $orderItem->commission_amount);
        
        $orderItem->stripe_charge_id = $chargeArray['stripe_charge']->id;
        $orderItem->stripe_status = $chargeArray['stripe_charge']->paid ? 'paid' : $chargeArray['stripe_charge']->status;
        $orderItem->status = $chargeArray['stripe_charge']->paid ? 'paid' : $chargeArray['stripe_charge']->status;
        $orderItem->commission_amount = $chargeArray['fee_amount'] ? round($chargeArray['fee_amount'] / 100, 2) : 0.0;
        $orderItem->save();
        
        return $orderItem->stripe_status;
    }

    /**
     * Check if customer exists, otherwise create one
     * 
     * @param User $user
     * @param string $token
     *
     * @return boolean
     */
    public function checkStripeCustomer(User $user, $token) {
        if ($user->stripe_id) {
            if ($user->cards()->isEmpty()) {
                $user->updateCard($token);
            }
            return (bool) $user->asStripeCustomer();
        } else {
            return (bool) $user->createAsStripeCustomer($token, ['email' => $user->email]);
        }             
    }
    
    /**
     * Create new charge for a Blog Story
     * 
     * @param string token
     *
     * @return void
     */
    public function createStoryCharge($token) {
        return StripeCharge::create([
            "amount" => config('services.blog.price') * 100,
            "currency" => "usd",
            "description" => "Charge for a Blog Post",
            "source" => $token,
        ]);
    }
}
