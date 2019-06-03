<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Requests\OrderUpdate;
use App\Models\Order;

trait OrderController {
    
    /**
     * Return all orders in json
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Request $request) {
        return Order::filter($request->all())
                        ->with('customer')
                        ->paginate($request->get('per_page', 10));
    }
    
    /**
     * Delete order
     *
     * @param Order $order
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Order $order) {
        return [
            'status' => $order->delete()
        ];
    }
    
    /**
     * Return the order
     * 
     * @param Order $order
     *
     * @return Order
     */
    public function getOrder(Order $order) {
        $order->items = $order->items()->with('item', 'license')->get();
        $order->story = $order->story;
        $order->customer = $order->customer;
        return $order;
    }
    
    /**
     * Update the order
     * 
     * @param Order $order
     * @param AdminSupportTicketUpdate $request
     * 
     * @return SupportTicket
     */
    public function updateOrder(Order $order, OrderUpdate $request) {
        $data = $request->only(['amount', 'payment_type', 'order_status']);
        $order->fill($data);
        $order->saveOrFail();
        return $order;
    }
}
