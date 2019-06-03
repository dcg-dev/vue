<?php

namespace App\Observers;

use App\Models\License;

class LicenseObserver {

    public function creating(License $model) {
        $model->incrementIndex();
    }

    public function deleting(Format $model) {
        $model->resetIndex();
    }
}
