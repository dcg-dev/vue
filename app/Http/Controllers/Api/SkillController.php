<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use Illuminate\Http\Request;

trait SkillController {

    /**
     * Return all skills in json
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request) {
        return Skill::filter($request->all())
                        ->orderBy('name')
                        ->where('enabled', true)
                        ->get();
    }

}
