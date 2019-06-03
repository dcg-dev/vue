<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{

    public function creating(Tag $model)
    {
        $model->name = strtolower($model->name);
    }

}
