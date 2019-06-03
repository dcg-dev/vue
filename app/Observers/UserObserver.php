<?php

namespace App\Observers;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cookie;

class UserObserver
{

    public function created(User $model)
    {
        $model->referred_by = Cookie::get('referral');
        $model->save();
        \Setting::set('members', \Setting::get('members', 0) + 1);
        \Setting::save();
    }

    public function deleted(User $model)
    {
        \Setting::set('members', \Setting::get('members', 0) - 1);
        \Setting::save();
    }

}
