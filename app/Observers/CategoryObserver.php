<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{

    public function creating(Category $model)
    {
        $model->incrementIndex();
    }

    public function updated(Category $model)
    {
        if ($model->isDirty('index')) {
            $index = min($model->index, $model->getOriginal('index'));
            $categories = Category::where('procreator_id', $model->procreator_id)->where('index', '>=', $index)->orderBy('index')->get();
            if ($index == $model->getOriginal('index')) {
                $key = $index - 1;
            } else {
                $key = $index;
            }
            foreach ($categories as $category) {
                if ($category->id == $model->id) {
                    continue;
                }
                $key++;
                $category->index = $key;
                $category->save();
            }
        }
    }

}
