<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserResetPasswordNotification extends Notification {

    use Queueable;

    private $token,$name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$name) {
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
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

        $url = config('url.dev.reset') . $this->token;
        $name = $this->name;
        $initials = $name[0];

        return (new MailMessage)->view(
            'emails.user.reset', ['url' => $url, 'name' => $name, 'initials' => $initials]
        )->subject('Stup  -  Esqueci minha senha');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
