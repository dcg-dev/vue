<?php

namespace App\Http\Controllers\Admin\Api;

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
    public function all()
    {
        return Category::orderBy('index')->whereNull('procreator_id')->with('childs')->get();
    }

    /**
     * Saves or creates a new category
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStore $request)
    {
        $data = $request->only([
            'name', 'index', 'procreator_id', 'enabled'
        ]);
        $category = new Category();
        if ($request->get('id')) {
            $category = Category::where('id', $request->get('id'))->firstOrFail();
            if (!$request->get('name')) {
                $data = ['index' => $request->get('index')];
            }
            if ($request->get('procreator_id') == $category->procreator_id) {
                unset($data['procreator_id']);
            }
        }
        $category->fill($data);
        $category->saveOrFail();
        return $category;
    }

    /**
     * Deletes the category
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Category $category, Request $request)
    {
        return [
            'status' => $category->delete()
        ];
    }

}
