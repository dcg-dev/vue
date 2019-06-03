<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AffiliateController extends Controller {
    
    use Api\AffiliateController;

    public function sales() {
        return view('affiliate.sales');
    }
    
    public function link() {
        return view('affiliate.link');
    }
    
}
