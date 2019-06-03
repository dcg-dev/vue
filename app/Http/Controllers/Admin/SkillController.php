<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SkillController extends Controller {

    use Api\SkillController;

    /**
     * Show list of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.skill.index');
    }

}
