<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller {

    use Api\CategoryController;
    /**
     * Show the notification settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.category.index');
    }

}
