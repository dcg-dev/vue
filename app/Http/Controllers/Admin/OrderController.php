<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller {

    use Api\OrderController;
    
    /**
     * Show list of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewList() {
        return view('admin.order.list');
    }
    
    /**
     * Show form to edit the order.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit(Order $order) {
        return view('admin.order.edit', ['order' => $order]);
    }
    
    /**
     * Show form to create an order.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate() {
        return view('admin.order.create');
    }

}
