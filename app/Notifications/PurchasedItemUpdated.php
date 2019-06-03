<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Item;

class PurchasedItemUpdated extends Notification
{
    
    protected $item;
    
    public function __construct(Item $item) {
        $this->item = $item;
    }

    /**
    * Get the notification's delivery channels.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function via($notifiable) {
        return ['database'];
    }
    
    /**
    * Get the array representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function toArray($notifiable) {
        return [
            'id' => $this->item->id,
            'name' => $this->item->name,
            'slug' => $this->item->slug,
        ];
    }
}