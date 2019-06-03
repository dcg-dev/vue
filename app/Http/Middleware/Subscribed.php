<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Plan;

class Subscribed {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards) {
        if (Auth::guest() || Auth::user()->subscribed('main')) {
            return $next($request);
        }
        $user = Auth::user();
        $plan = Plan::where('price', 0)->orWhere('price', null)->orderBy('index')->first();
        if (!$plan) {
            return $next($request);
        }
        $data = [
            'plan' => $plan->stripe_id,
            'email' => $user->email,
            'metadata' => [
                'user_id' => $user->id,
                'username' => $user->username,
                'name' => $user->fullname,
            ],
        ];
        $customer = $user->stripe_id ? $user->asStripeCustomer() : $user->createAsStripeCustomer(null, $data);
        $subscriptions = Collection::make($customer->subscriptions->data);
        $subscription = $subscriptions->last();
        $user->stripe_id = $customer->id;
        $user->subscriptions()->create([
            'name' => 'main',
            'stripe_id' => isset($subscription->id) ? $subscription->id : $user->newSubscription('main', $plan->stripe_id)->create()->id,
            'stripe_plan' => $plan->stripe_id,
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);
        $user->save();
        return $next($request);
    }

}
