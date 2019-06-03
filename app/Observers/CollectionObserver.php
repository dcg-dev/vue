<?php

namespace App\Observers;

use App\Models\Collection;

class CollectionObserver {

    public function created(Collection $model) {
        $model->creator->recalculateCollections();
        $model->creator->save();
    }

    public function deleted(Collection $model) {
        $model->creator->recalculateCollections();
        $model->creator->save();
    }

}
