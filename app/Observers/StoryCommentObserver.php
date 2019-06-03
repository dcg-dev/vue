<?php

namespace App\Observers;

use App\Models\StoryComment;

class StoryCommentObserver {

    public function created(StoryComment $model) {
        $model->story->recalculateComments();
        $model->story->save();
    }

    public function deleting(StoryComment $model) {
        $model->story->recalculateComments();
        $model->story->save();
    }

}
