<?php

namespace App\Observers;

use App\Models\Rating;

class RatingObserver {

    public function created(Rating $model) {
        $model->item->creator->notifyNewItemReview($model->item);
        $model->item->recalculateRatings();
        $model->item->save();
        
        $model->item->creator->recalculateRatings();
        $model->item->creator->save();
    }

    public function deleting(Rating $model) {
        $model->item->recalculateRatings();
        $model->item->save();
        
        $model->item->creator->recalculateRatings();
        $model->item->creator->save();
    }

}
