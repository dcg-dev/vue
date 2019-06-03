<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PromoPlanController extends Controller {

    use Api\PromoPlanController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.promo-plan.index');
    }

}
