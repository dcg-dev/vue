<?php

namespace App\Models;

use App\Observers\SubscriptionObserver;
use EloquentFilter\Filterable;

class Subscription extends \Laravel\Cashier\Subscription
{

    use Filterable;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::observe(new SubscriptionObserver());
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'ended_at' => 'timestamp',
        'trial_ends_at' => 'timestamp',
    ];

    /**
     * Returns a customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns a customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'stripe_plan', 'stripe_id');
    }

    /**
     * Swap the subscription to a new Stripe plan.
     *
     * @param  string $plan
     * @return $this
     */
    public function swap($plan, $meta = false)
    {
        $subscription = $this->asStripeSubscription();

        $subscription->plan = $plan;

        $subscription->prorate = $this->prorate;

        if ($subscription->items->data) {
            $subscription->items->data[0];
        }

        if ($meta) {
            $subscription->metadata = $meta;
        }

        if (!is_null($this->billingCycleAnchor)) {
            $subscription->billingCycleAnchor = $this->billingCycleAnchor;
        }

        // If no specific trial end date has been set, the default behavior should be
        // to maintain the current trial state, whether that is "active" or to run
        // the swap out with the exact number of days left on this current plan.
        if ($this->onTrial()) {
            $subscription->trial_end = $this->trial_ends_at->getTimestamp();
        } else {
            $subscription->trial_end = 'now';
        }

        // Again, if no explicit quantity was set, the default behaviors should be to
        // maintain the current quantity onto the new plan. This is a sensible one
        // that should be the expected behavior for most developers with Stripe.
        if ($this->quantity) {
            $subscription->quantity = $this->quantity;
        }

        $subscription->save();

        $this->user->invoice();

        $this->fill([
            'stripe_plan' => $plan,
            'ends_at' => null,
        ])->save();

        return $this;
    }
}
