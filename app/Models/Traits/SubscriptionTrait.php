<?php

namespace App\Models\Traits;

use App\Models\Plan;


trait SubscriptionTrait {

    /**
     * @return mixed
     */
    public function getPlan() {

        // TODO replace to relation
        if ($this->subscribed('main')) {
            return Plan::where('stripe_id', $this->subscription('main')->stripe_plan)->first();
        }
    }
}
