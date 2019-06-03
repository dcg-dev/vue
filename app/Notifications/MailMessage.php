<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage as BaseMailMessage;

class MailMessage extends BaseMailMessage
{
    public $image = null;

    /**
     * Set the "image" of the notification.
     *
     * @param  string $src
     * @return $this
     */
    public function image($src)
    {
        $this->image = $src;
        return $this;
    }

    /**
     * Get an array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['image'] = $this->image;
        return $data;
    }
}