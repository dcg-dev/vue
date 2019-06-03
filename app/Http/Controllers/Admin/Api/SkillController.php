<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Skill\SkillCreate;
use App\Http\Requests\Skill\SkillUpdate;
use App\Models\Skill;
use Illuminate\Http\Request;

trait SkillController {

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function skills(Request $request) {
        return Skill::filter($request->all())
            ->paginate($request->get('per_page', 15));
    }

    /**
     * @param \App\Http\Requests\Skill\SkillCreate $request
     * @return \App\Models\Skill
     */
    public function create(SkillCreate $request) {
        $attributes = $request->all();
        $skill = new Skill();
        $skill->fill($attributes);
        $skill->saveOrFail();
        return $skill;
    }

    /**
     * @param \App\Models\Skill $skill
     * @param \App\Http\Requests\Skill\SkillUpdate $request
     * @return \App\Models\PromoPlan
     */
    public function update(Skill $skill, SkillUpdate $request) {
        $attributes = $request->all();
        $skill->fill($attributes);
        $skill->save();
        return $skill;
    }

    /**
     * @param \App\Models\Skill $skill
     * @return array
     */
    public function delete(Skill $skill) {
        return [
            'status' => $skill->delete()
        ];
    }
}
