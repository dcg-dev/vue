<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Order\OrderItemRepository;
use Illuminate\Http\Request;

/**
 * Trait SalesController
 * @package App\Http\Controllers\Api
 */
class OrderController extends Controller {

    /**
     * @var \App\Repositories\Order\OrderItemRepository
     */
    protected $orderItem;

    /**
     * InboxMessageController constructor.
     *
     * @param \App\Repositories\Order\OrderItemRepository $orderItem
     */
    public function __construct(OrderItemRepository $orderItem) {
        $this->orderItem = $orderItem;
    }

    /**
     * Return all order items.
     *
     * @param Request $request
     * @return mixed
     */
    public function all(Request $request) {
        return $this->orderItem->all()->paginate($request->get('perPage', 10));
    }

    /**
     * Return counts of order items.
     *
     * @return array
     */
    public function counts() {
        return $this->orderItem->counts();
    }

    /**
     * Return purchased items.
     *
     * @param Request $request
     * @return mixed
     */
    public function purchased(Request $request) {
        return $this->orderItem->purchased()->orderBy('updated_at', 'desc')->paginate($request->get('perPage', 10));
    }

    /**
     * Return all transactions.
     *
     * @param Request $request
     * @return mixed
     */
    public function billing(Request $request) {
        return $this->orderItem->billing($request->all());
    }
}
