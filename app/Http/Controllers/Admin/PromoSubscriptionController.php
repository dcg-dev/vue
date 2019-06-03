<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PromoSubscriptionController extends Controller {

    use Api\PromoSubscriptionController;
    
    /**
     * Show list of the promotional.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewList() {
        return view('admin.promo-subscription.list');
    }
}
