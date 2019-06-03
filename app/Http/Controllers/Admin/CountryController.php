<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CountryController extends Controller {

    use Api\CountryController;

    /**
     * Show list of the vats.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.country.index');
    }

}
