<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Format\FormatIndex;
use App\Http\Requests\Format\FormatStore;
use App\Models\Format;
use Illuminate\Http\Request;

trait FormatController {

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function formats(Request $request) {
        return Format::orderBy('index')
            ->get();
    }

    /**
     * Saves or creates a new format
     *
     * @param \App\Http\Requests\Format\FormatStore $request
     * @return \App\Models\Format
     */
    public function store(FormatStore $request) {
        $data = $request->all();

        $format = new Format();
        if ($request->get('id')) {
            $format = Format::where('id', $request->get('id'))->firstOrFail();
            if (!$request->get('name')) {
                $data = ['index' => $request->get('index')];
            }
        }
        $format->fill($data);
        $format->saveOrFail();
        return $format;
    }

    /**
     * @param \App\Http\Requests\Format\FormatIndex $request
     * @return \App\Models\Format
     */
    public function sort(FormatIndex $request) {
        $format = Format::where('id', $request->get('id'))->firstOrFail();
        if (!$request->get('name')) {
            $data = ['index' => $request->get('index')];
        }

        if ($format->index > $request->get('index')) {
            Format::where('index', '>=', $request->get('index'))->increment('index');
        } else {
            Format::where('index', '<=', $request->get('index'))->decrement('index');
        }

        $format->fill($data);
        $format->saveOrFail();
        return $format;
    }

    /**
     * @param \App\Models\Format $format
     * @return array
     */
    public function delete(Format $format) {
        return [
            'status' => $format->delete()
        ];
    }
}
