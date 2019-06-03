<?php

namespace App\Observers;

use App\Models\StoryCommentLike;

class StoryCommentLikeObserver {

    public function created(StoryCommentLike $model) {
        $model->comment->recalculateLikes();
        $model->comment->save();
    }

    public function deleted(StoryCommentLike $model) {
        $model->comment->recalculateLikes();
        $model->comment->save();
    }

}
