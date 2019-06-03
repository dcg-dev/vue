<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProfileController extends Controller {

    use Api\ProfileController;

    public function edit() {
        return view('profile.edit');
    }

    public function settings() {
        return view('profile.settings');
    }
    
    public function notifications() {
        return view('profile.notifications');
    }

    public function inbox() {
        return view('profile.inbox');
    }
    public function compose() {
        return view('profile.compose');
    }

    public function subscriptions() {
        return view('profile.subscriptions');
    }

    public function dashboard() {
        return view('profile.dashboard');
    }

    public function sales() {
        return view('profile.sales');
    }

    public function downloads() {
        return view('profile.downloads');
    }

    public function promotions() {
        return view('profile.promotions');
    }
}
