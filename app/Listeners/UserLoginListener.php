<?php

namespace App\Listeners;


class UserLoginListener
{
    /**
     * Handle the event.
     *
     * @param  auth .login  $event
     * @return void
     */
    public function handle($event)
    {
        $event->user->online();
    }
}