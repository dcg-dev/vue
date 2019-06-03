<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Format;

trait FormatController {

    /**
     * Returns list of all formats
     *
     * @return \Illuminate\Http\Response
     */
    public function all() {
        return Format::where('enabled', true)->orderBy('index')->orderBy('name')->get();
    }

}
