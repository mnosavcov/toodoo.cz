<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OverrideResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
                    'plainText' => 'Na základě Vašeho požadavku Vám zasíláme odkaz pro obnovení hesla. Zkopírujte přiložený odkaz do prohlížeče.' . "\n" . url('password/reset', $this->token)
                ]
            )
            ->subject('Obnovení hesla')
            ->line(['Na základě Vašeho požadavku Vám zasíláme odkaz pro obnovení hesla.',
                'Klikněte prosím na tlačítko.'])
            ->action('Obnovit heslo', url('password/reset', $this->token));
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
