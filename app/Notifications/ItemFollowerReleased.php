<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Item;

class ItemFollowerReleased extends Notification
{

    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->item->id,
            'name' => $this->item->name,
            'slug' => $this->item->slug,
            'username' => $this->item->creator->username
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hey there!')
            ->subject('"' . $this->item->creator->username . '" has just released  a new item.')
            ->line('"' . $this->item->creator->username . '" has just released  a new item.')
            ->action($this->item->name, route('item', ['item' => $this->item->slug], true))
            ->line('You’ve subscribed to «' . $this->item->creator->username . '» for new item releases.');
//            ->image($this->item->image)
//            ->line('You can change your notifications settings here or unsubscribe.');
    }
}