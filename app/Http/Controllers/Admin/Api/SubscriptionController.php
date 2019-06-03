<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait SubscriptionController
{

    /**
     * Return all subscriptions in json
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubscriptions(Request $request)
    {
        return Subscription::filter($request->all())
            ->select(
                '*',
                DB::Raw("CASE WHEN ends_at IS NULL THEN 'active' ELSE 'close' END as status"))
            ->with('customer')
            ->whereNotIn('stripe_plan', ['Free', 'free'])
            ->paginate($request->get('per_page', 10));
    }

    /**
     * Cancel subscription
     *
     * @param \App\Models\Subscription $subscription
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(Subscription $subscription)
    {
        return [
            'status' => $subscription->customer->subscription('main')->cancelNow() ? true : false
        ];
    }
}
