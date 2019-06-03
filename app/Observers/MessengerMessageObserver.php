<?php

namespace App\Observers;

use App\Models\Messenger\MessengerMessage;
use Illuminate\Support\Facades\Auth;

class MessengerMessageObserver
{


    public function created(MessengerMessage $model)
    {
        $participants = $model->thread->participants;
        foreach ($participants as $participant) {
            $user = $participant->user;
            if ($user->id != Auth::user()->id) {
                $user->notifyNewMessage($user);
            }
        }
    }
}
