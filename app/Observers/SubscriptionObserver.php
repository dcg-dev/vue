<?php

namespace App\Observers;

use App\Models\AffiliateSale;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionObserver
{

    public function saving(Subscription $model)
    {
        if ($model->getOriginal('stripe_plan') == 'Free'
            && $model->plan
            && Auth::user()->referred_by
            && $reciever = User::where('username', Auth::user()->referred_by)->first()
        ) {
            AffiliateSale::create([
                'user_id' => $reciever->id,
                'affiliable_id' => $model->id,
                'affiliable_type' => Subscription::class,
                'amount' => round($model->plan->price * config('services.referral.percent.subscriptions') / 100, 2)
            ]);
        }
    }


}
