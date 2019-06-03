<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\PromoSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait PromoSubscriptionController {
    
    /**
     * Return all promotional in json
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubscriptions(Request $request) {
        return PromoSubscription::filter($request->all())
                        ->select(
                            'id',
                            'user_id',
                            'plan_id',
                            'ends_at',
                            'created_at',
                            DB::Raw("CASE WHEN ends_at > NOW() THEN 'active' ELSE 'close' END as status"))
                        ->with('customer')
                        ->with('plan')
                        ->with('items')
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Cancel promotional
     *
     * @param \App\Models\PromoSubscription $subscription
     * 
     * @return \Illuminate\Http\Response
     */
    public function cancel(PromoSubscription $subscription) {
        $subscription->ends_at = Carbon::now();
        $subscription->save();

        return [
            'status' => true
        ];
    }
}
