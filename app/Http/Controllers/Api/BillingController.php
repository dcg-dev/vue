<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PromoPlanBuy;
use App\Models\Item;
use App\Models\PromoPlan;
use App\Models\PromoSubscription;
use App\Models\PromoSubscriptionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Plan;
use function Symfony\Component\Console\Tests\Command\createClosure;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Stripe\Charge as StripeCharge;

trait BillingController
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function plans(Request $request)
    {
        return Plan::filter($request->all())
            ->where('enabled', true)
            ->orderBy('price')
            ->paginate($request->get('per_page', 6));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function promoPlans(Request $request)
    {
        return PromoPlan::filter($request->all())
            ->where('enabled', true)
            ->orderBy('price')
            ->paginate($request->get('per_page', 6));
    }

    /**
     * Subscribe to the plan.
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe($id, Request $request)
    {

        $plan = Plan::findOrFail($id);

        if ($this->user()->subscribed('main')) {
            if ($this->user()->subscribedToPlan($plan->stripe_id, 'main')) {
                throw new BadRequestHttpException("It's your current plan!");
            }
            if (!$this->user()->isAdmin() && $this->user()->items->count() > $plan->products) {
                throw new BadRequestHttpException("Sorry, you can not downgrade the subscription until you don't reduce your items quantity to the required.");
            }
            $response = $this->user()
                ->subscription('main')
                ->swap($plan->stripe_id, [
                    'description' => 'Subscription swap ' . $plan->name . ' (' . number_format($plan->price, 2) . '/month)',
                ]);
        } else {
            $response = $this->user()
                ->newSubscription('main', $plan->stripe_id)
                ->withMetadata([
                    'description' => 'Subscription ' . $plan->name . ' (' . number_format($plan->price, 2) . '/month)',
                ])
                ->create($request->get('token'));
        }

        return $response;
    }

    /**
     * @param $id
     * @return bool
     */
    public function availableSubscribe($id)
    {
        $plan = Plan::findOrFail($id);
        $status = true;
//        if ($plan->price < $this->user()->plan('main')->price) {
        if ($this->user()->items->count() > $plan->products) {
            $status = false;
        }
//        }

        return [
            'status' => $status
        ];
    }

    /**
     * @param \App\Models\PromoPlan $plan
     * @param \App\Http\Requests\PromoPlanBuy $request
     * @return bool
     */
    public function buyPromo(PromoPlan $plan, PromoPlanBuy $request)
    {
        if (!$this->user()->subscribed('main')) {
            throw new BadRequestHttpException('You must have a subscription.');
        }

        $item = Item::find($request->get('item'));

        if (PromoSubscription::checkItem($item->id)) {
            throw new BadRequestHttpException('Item already has a subscription');
        }

        $params = [
            'currency' => 'usd',
            'amount' => $plan->price * 100,
            'description' => sprintf('Buy promotional subscription for %s.', $item->name),
            'source' => $request->get('token'),
        ];

        $charge = StripeCharge::create($params);

        if ($charge->status == 'succeeded') {
            $date = Carbon::now();
            $date->{'add' . $plan->duration_type . 's'}($plan->duration);

            $subscription = PromoSubscription::create([
                'user_id' => $this->user()->id,
                'plan_id' => $plan->id,
                'ends_at' => $date
            ]);

            $subscription->items()->sync($item->id);
        }

        return [
            'success' => true
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function invoices(Request $request)
    {
        if (!$this->user()->hasStripeId() || !$this->user()->asStripeCustomer()) {
            return [];
        }

        $invoices = $this->user()->invoices();

        return collect($invoices)->map(function ($item) {
            return [
                'id' => $item->id,
                'date' => $item->date()->toFormattedDateString(),
                'description' => ($item = collect($item->invoiceItemsByType('subscription'))->first()) ? $item->metadata->description : null,
                'total' => $item->total()
            ];
        })->forPage($request->get('page'), 10)->values();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function renewalSubscription(Request $request)
    {
        if (!$this->user()->subscribed('main')) {
            throw new BadRequestHttpException('You must have a subscription.');
        }

        if (!$request->has('renewal')) {
            throw new BadRequestHttpException('Invalid parameters');
        }

        if ($request->get('renewal')) {
            $response = $this->user()->subscription('main')->resume();
        } else {
            $response = $this->user()->subscription('main')->cancel();
        }

        return $response;
    }
}
