<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LicenseController extends Controller {

    use Api\LicenseController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.license.index');
    }

}
