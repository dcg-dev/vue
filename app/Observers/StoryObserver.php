<?php

namespace App\Observers;

use App\Models\Story;

class StoryObserver
{

    public function updated(Story $model)
    {
        if ($model->isDirty('approved')) {
            if ($model->approved) {
                $model->creator->notifyStoryReleased($model);
            }
        }
    }

    public function created(Story $model)
    {
        $creator = $model->creator;
        $creator->recalculateStories();
        $creator->save();
    }

    public function deleted(Story $model)
    {
        $creator = $model->creator;
        $creator->recalculateStories();
        $creator->save();
    }

}
