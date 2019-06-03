<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class SubscriptionController extends Controller {

    use Api\SubscriptionController;
    
    /**
     * Show list of the subscriptions.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewList() {
        return view('admin.subscription.list');
    }
}
