<?php

namespace App\Observers;

use App\Models\Plan;

/**
 * Class PlanObserver
 * @package App\Observers
 */
class PlanObserver {

    /**
     * @param Plan $model
     * @throws \Exception
     */
    public function creating(Plan $model) {
        if (Plan::canCreate() === false) {
            throw new \Exception('The limit for creating plans has been reached. To create a new plan, you need to disable or delete the existing plan.');
        }
    }

}
