<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Tag\TagCreate;
use App\Http\Requests\Tag\TagUpdate;
use App\Models\Tag;
use Illuminate\Http\Request;

trait TagController {

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function tags(Request $request) {
        return Tag::filter($request->all())
            ->paginate($request->get('per_page', 15));
    }

    /**
     * @param \App\Http\Requests\Tag\TagCreate $request
     * @return \App\Models\Tag
     */
    public function create(TagCreate $request) {
        $attributes = $request->all();
        $tag = new Tag();
        $tag->fill($attributes);
        $tag->saveOrFail();
        return $tag;
    }

    /**
     * @param \App\Models\Tag $tag
     * @param \App\Http\Requests\Tag\TagUpdate $request
     * @return \App\Models\PromoPlan
     */
    public function update(Tag $tag, TagUpdate $request) {
        $attributes = $request->all();
        $tag->fill($attributes);
        $tag->save();
        return $tag;
    }

    /**
     * @param \App\Models\Tag $tag
     * @return array
     */
    public function delete(Tag $tag) {
        $tag->delete();

        return [
            'status' => true
        ];
    }
}
