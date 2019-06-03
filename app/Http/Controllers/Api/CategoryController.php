<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryStore;

trait CategoryController
{

    /**
     * Return all categories in json
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $query = Category::orderBy('index')->where('enabled', true);
        if ($request->has('ids')) {
            $query->whereIn('id', $request->get('ids', []));
        } else {
            $query->whereNull('procreator_id');
        }
        return $query->paginate($request->get('per_page', 20));
    }

    public function select()
    {
        $categories = Category::orderBy('index')
            ->select(['name', 'id'])
            ->whereNull('procreator_id')
            ->where('enabled', true)->get();
        $results = [];
        if ($categories) {
            foreach ($categories as $category) {
                $data = [
                    'text' => $category->name
                ];
                $data['children'] = [];
                if ($category->childs) {
                    foreach ($category->childs as $child) {
                        $data['children'][] = [
                            'text' => $child->name,
                            'id' => $child->id,
                        ];
                    }
                }
                if (!empty($data['children'])) {
                    $results[] = $data;
                }
            }
        }
        return $results;
    }

}
