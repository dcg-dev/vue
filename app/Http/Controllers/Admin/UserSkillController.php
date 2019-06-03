<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;

class UserSkillController extends Controller {

    use Api\UserSkillController;
    
    /**
     * Show the form to create new skill
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCreate() {
        return view('admin.user.skill.create');
    }
    
    /**
     * Show the form to edit skill
     * 
     * @param Skill
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEdit(Skill $skill) {
        return view('admin.user.skill.edit', ['skill' => $skill]);
    }

}
