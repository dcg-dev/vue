<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Requests\SkillCreate;
use App\Http\Requests\SkillUpdate;
use App\Models\Skill;

trait UserSkillController {

    /**
     * Return all skills in json
     *
     * @return Skill
     */
    public function all(Request $request) {
        return Skill::orderBy('created_at', 'desc')->paginate($request->get('per_page', 20));
    }
    /**
     * Return skill in request
     * 
     * @param Skill
     *
     * @return Skill
     */
    public function get(Skill $skill) {
        return $skill;
    }
    
    
    /**
     * Change enabled/disabled status
     *
     * @return Skill
     */
    public function approving(Skill $skill, Request $request) {
        $skill->enabled = $request->get('enabled');
        $skill->saveOrFail();
        return $skill;
    }

    /**
     * Create new skill
     * 
     * @param SkillCreate $request
     * 
     * @return Skill
     */
    public function create(SkillCreate $request) {
        $data = $request->only(['name', 'enabled']);
        $skill = new Skill();
        $skill->fill($data);
        $skill->saveOrFail();
        return $skill;
    }
    
    /**
     * Update the skill
     * 
     * @param SkillUpdate $request
     * 
     * @return Skill
     */
    public function update(Skill $skill, SkillUpdate $request) {
        $data = $request->only(['name', 'slug', 'enabled']);
        $skill->fill($data);
        $skill->saveOrFail();
        return $skill;
    }
    
    /**
     * Delete the skill
     *
     * @return array
     */
    public function delete(Skill $skill, Request $request) {
        return [
            'status' => $skill->delete()
        ];
    }

}
