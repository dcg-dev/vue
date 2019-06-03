<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\PromoPlanCreate;
use App\Http\Requests\PromoPlanUpdate;
use App\Models\PromoPlan;
use Illuminate\Http\Request;

trait PromoPlanController {

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function plans(Request $request) {
        return PromoPlan::filter($request->all())
            ->paginate($request->get('per_page', 5));
    }

    /**
     * @param \App\Http\Requests\PromoPlanCreate $request
     * @return \App\Models\PlanPromo
     */
    public function create(PromoPlanCreate $request) {
        $attributes = $request->all();
        $plan = new PromoPlan();
        $plan->fill($attributes);
        $plan->saveOrFail();
        return $plan;
    }

    /**
     * @param \App\Models\PromoPlan $plan
     * @param \App\Http\Requests\PromoPlanUpdate $request
     * @return \App\Models\PromoPlan
     */
    public function update(PromoPlan $plan, PromoPlanUpdate $request) {
        $attributes = $request->all();
        $plan->fill($attributes);
        $plan->save();
        return $plan;
    }

    /**
     * @param \App\Models\PromoPlan $plan
     * @return array
     */
    public function delete(PromoPlan $plan) {
        $plan->delete();

        return [
            'status' => true
        ];
    }
}
