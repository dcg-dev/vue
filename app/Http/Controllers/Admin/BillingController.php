<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;

class BillingController extends Controller {

    use Api\BillingController;
    
    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function plansSearch() {
        return view('admin.billing.plans');
    }

}
