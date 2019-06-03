<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Collection;

class NotificationCollection extends Collection
{
    /**
     * Mark all notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->each(function ($notification) {
            $notification->markAsRead();
        });
    }
}
