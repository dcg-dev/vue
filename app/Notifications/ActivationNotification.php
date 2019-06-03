<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationNotification extends Notification {

    use Queueable;

    /**
     * The activation token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
                        ->line("Thank you for registering at Roqstar. You're almost there.")
                        ->line("Please confim your email address to activate your account by clicking the button below.")
                        ->action('Activation link', url(config('app.url') . route('user.activation', $this->token, false)))
                        ->line("After you're done you will have access to the platform and use all the great tools we have to offer.")
                        ->line("You can follow other inspiring people and share your best items with them.");
    }

}
