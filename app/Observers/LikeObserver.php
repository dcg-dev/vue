<?php

namespace App\Observers;

use App\Models\Like;

class LikeObserver {

    public function created(Like $model) {
        $model->comment->recalculateLikes();
        $model->comment->save();
    }

    public function deleting(Like $model) {
        $model->comment->recalculateLikes();
        $model->comment->save();
    }

}
