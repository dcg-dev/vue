<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FaqTopic;

trait FaqController {

    /**
     * Return all faq categories in json without pagination
     *
     * @return \Illuminate\Http\Response
     */
    public function allFaqTopics(Request $request) {
        return FaqTopic::filter($request->all())->get();
    }

}
