<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PageController extends Controller {

    public function startSelling() {
        return view('page.start_selling');
    }

    public function community() {
        return view('page.community');
    }
    
    public function pricing() {
        return view('page.pricing');
    }

    public function dashboard() {
        return view('dashboard.index', [
            'itemsPagination' => \Setting::get('pagination.dashboard.items') ?: 0,
            'popularPagination' => \Setting::get('pagination.dashboard.popular') ?: 0,
            'featuredPagination' => \Setting::get('pagination.dashboard.featured') ?: 0,
            'storiesPagination' => \Setting::get('pagination.dashboard.stories') ?: 0,
            'sellersPagination' => \Setting::get('pagination.dashboard.sellers') ?: 0
        ]);
    }
}
