<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Requests\CategoryStore;
use Illuminate\Http\Request;

trait TagController {

    /**
     * Return all categories in json
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request) {
        return Tag::filter($request->all())
                        ->orderBy('name')
                        ->where('enabled', true)
                        ->paginate(20);
    }

}
