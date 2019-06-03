<?php

namespace App\Http\Controllers\Api;

use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Item;
use App\Models\User;

trait PayPalController {
    
    /**
     * Check if possible to make payment by PayPal gateway
     *
     * @return bool
     */
    public function possiblePayPal() {
        foreach(Cart::getContent() as $item) {
            $currentItem = Item::findOrFail($item->id);
            $currentUser = User::findOrFail($currentItem->creator_id);
            if (!$currentUser->paypal_email) {
                return false;
            }
        } 
        return true;
    }
}
