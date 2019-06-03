<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver {

    public function created(Comment $model) {
        $model->item->creator->notifyNewItemComment($model->item);
        $model->item->recalculateComments();
        $model->item->save();
    }

    public function deleted(Comment $model) {
        $model->item->recalculateComments();
        $model->item->save();
    }

}
