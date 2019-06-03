<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BillingController extends Controller {

    use Api\BillingController;

    /**
     * Show the subscription list
     *
     * @return \Illuminate\Http\Response
     */
    public function upgrade() {
        return view('billing.subscription.upgrade');
    }
    
    /**
     * Show the subscripbe page
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Plan $plan) {
        if($this->user()->subscribed('main') && $this->user()->subscription('main')->stripe_plan == $plan->stripe_id) {
            abort(403, "It's your current plan!");
        }
        return view('billing.subscription.view', [
            'plan' => $plan
        ]);
    }

    /**
     * Show invoice.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invoice(Order $order) {
        $items = $order->items;
        $total = $items->sum('price');
        $buyer = $order->customer;
        $seller = $items->first()->item->creator;

        return view('billing.invoice', compact('items', 'total', 'buyer', 'seller'));
    }
}
