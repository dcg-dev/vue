<?php

namespace App\Observers;

use App\Models\Format;

class FormatObserver {

    public function creating(Format $model) {
        $model->incrementIndex();
    }

    public function deleting(Format $model) {
        $model->resetIndex();
    }

}
