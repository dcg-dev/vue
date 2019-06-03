<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller {

    use Api\CheckoutController,
        Api\StripeController,
        Api\PayPalController;

    public function checkoutView() {
        return view('checkout.view');
    }
    
}
