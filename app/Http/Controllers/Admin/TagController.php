<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TagController extends Controller {

    use Api\TagController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.tag.index');
    }

}
