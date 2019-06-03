<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\License;

trait LicenseController {

    /**
     * Returns list of all formats
     *
     * @return \Illuminate\Http\Response
     */
    public function all() {
        return License::where('enabled', true)->orderBy('index')->orderBy('name')->get();
    }

}
