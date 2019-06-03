<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationEmail {

    /**
     * Handle the event.
     *
     * @param  auth.register  $event
     * @return void
     */
    public function handle(Registered $event) {
        $user = $event->user;
        $user->generateActivationToken();
        if ($user->save()) {
            $user->sendActivationNotification($user->activation_token);
            return true;
        }
        return false;
    }

}
