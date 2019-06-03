<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Item;

class NewSale extends Notification
{

    protected $item, $price;

    public function __construct(Item $item, $price)
    {
        $this->item = $item;
        $this->price = $price;
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
            'price' => $this->price
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
            ->subject('Notification')
            ->line('You have new sale the "' . $this->item->name . '" item.')
            ->action("Sales", route('profile.sales', [], true));
    }
}