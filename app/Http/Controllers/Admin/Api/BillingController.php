<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use Stripe\Plan as StripePlan;
use App\Http\Requests\PlanCreate;
use App\Http\Requests\PlanUpdate;
use App\Models\Plan;

trait BillingController {

    public function plans(Request $request) {
        return Plan::filter($request->all())
                        ->paginate($request->get('per_page', 5));
    }

    public function create(PlanCreate $request) {
        try {
            $result = StripePlan::create([
                        'id' => $request->get('stripe_id'),
                        'amount' => $request->get('price'),
                        'currency' => 'usd',
                        'interval' => 'month',
                        'name' => $request->get('name'),
            ]);
        } catch (\Stripe\Error\InvalidRequest $ex) {
            if ($ex->getMessage() != 'Plan already exists.') {
                throw $ex;
            }
        }
        $attributes = $request->only(['name', 'stripe_id', 'products', 'commission',
            'price', 'paypal', 'card', 'social_accounts', 'builder',
            'notifications', 'support', 'badge', 'enabled']);
        $plan = new Plan();
        $plan->incrementIndex();
        $plan->fill($attributes);
        $plan->saveOrFail();
        return $plan;
    }

    public function update(Plan $plan, PlanUpdate $request) {
        $attributes = $request->only(['name', 'stripe_id', 'products', 'commission',
            'price', 'paypal', 'card', 'social_accounts', 'builder',
            'notifications', 'support', 'badge', 'enabled']);
        $plan->fill($attributes);
        if ($plan->isDirty(['amount', 'name'])) {
            $stripe = StripePlan::retrieve($plan->stripe_id);
            $stripe->name = $request->get('name');
            $stripe->save();
        }
        $plan->saveOrFail();
        return $plan;
    }

    public function delete(Plan $plan) {
        $stripe = StripePlan::retrieve($plan->stripe_id);
        $stripe->delete();
        $plan->delete();
        return [
            'status' => true
        ];
    }

}
