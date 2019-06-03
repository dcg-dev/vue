<?php

namespace App\Http\Controllers;

use App\Facades\PayPalPayment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayPalController extends Controller {

    /**
     *
     */
    public function success() {
        return redirect()->route('dashboard');
    }
    
    /**
     *
     */
    public function cancel() {
        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     */
    public function ipn(Request $request) {
        if (PayPalPayment::verifyIPN($request->all())) {
            $status = strtolower($request->get('status'));

            if ($status == 'completed') {
                $status = Order::STATUS_PAID;
            }

            $orderId = $request->get('o');

            DB::transaction(function () use ($status, $orderId) {
                Order::where('id', $orderId)
                    ->update(['order_status' => $status]);

                OrderItem::where('order_id', $orderId)
                    ->update(['status' => $status]);
            });
        }
    }
}
