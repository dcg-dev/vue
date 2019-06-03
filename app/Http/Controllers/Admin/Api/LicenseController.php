<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\License\LicenseIndex;
use App\Http\Requests\License\LicenseStore;
use App\Models\License;
use Illuminate\Http\Request;

trait LicenseController {

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function licenses(Request $request) {
        return License::orderBy('index')
            ->get();
    }

    /**
     * Saves or creates a new license
     *
     * @param \App\Http\Requests\License\LicenseStore $request
     * @return \App\Models\License
     */
    public function store(LicenseStore $request) {
        $data = $request->all();

        $license = new License();
        if ($request->get('id')) {
            $license = License::where('id', $request->get('id'))->firstOrFail();
            if (!$request->get('name')) {
                $data = ['index' => $request->get('index')];
            }
        }
        $license->fill($data);
        $license->saveOrFail();
        return $license;
    }

    /**
     * @param \App\Http\Requests\License\LicenseIndex $request
     * @return \App\Models\License
     */
    public function sort(LicenseIndex $request) {
        $license = License::where('id', $request->get('id'))->firstOrFail();
        if (!$request->get('name')) {
            $data = ['index' => $request->get('index')];
        }

        if ($license->index > $request->get('index')) {
            License::where('index', '>=', $request->get('index'))->increment('index');
        } else {
            License::where('index', '<=', $request->get('index'))->decrement('index');
        }

        $license->fill($data);
        $license->saveOrFail();
        return $license;
    }

    /**
     * @param \App\Models\License $license
     * @return array
     */
    public function delete(License $license) {
        return [
            'status' => $license->delete()
        ];
    }
}
