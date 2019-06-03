<?php

namespace App\Observers;

use App\Models\StoryLike;

class StoryLikeObserver {

    public function created(StoryLike $model) {
        $model->story->recalculateLikes();
        $model->story->save();
    }

    public function deleted(StoryLike $model) {
        $model->story->recalculateLikes();
        $model->story->save();
    }

}
