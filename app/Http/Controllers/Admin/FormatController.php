<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class FormatController extends Controller {

    use Api\FormatController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.format.index');
    }

}
