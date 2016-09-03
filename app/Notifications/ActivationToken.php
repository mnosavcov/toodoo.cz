<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationToken extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view([
                'html' => 'vendor.notifications.email',
                'text' => 'vendor.notifications.email-text'
            ],
                [
                    'plainText' => 'Děkujeme za Vaši registraci na portálu TooDoo.cz. Pro aktivaci účtu zkopírujte přiložený odkaz do prohlížeče.' . "\n" . route('account.activation', ['email' => $this->user->email, 'token' => $this->user->activation_token])
                ]
            )
            ->subject('Aktivace účtu TooDoo.cz')
            ->line('Děkujeme za Vaši registraci na portálu TooDoo.cz. Pro aktivaci účtu klikněte na odkaz.')
            ->action('Aktivovat', route('account.activation', ['email' => $this->user->email, 'token' => $this->user->activation_token]));
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
            //
        ];
    }
}
