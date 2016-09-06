<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentConfirmation extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
        $payment = $this->payment;

        $text = 'Děkujeme za Vaši platbu.' . "\n\n";
        $text .= 'Rekapitulace:' . "\n\n";
        $text .= 'Platba ze dne ' . date('d.m.Y', $payment->paid_at) . "\n";
        $text .= 'Výše platby: ' . $payment->paid_amount . ',- Kč' . "\n";
        $text .= 'Variabilní symbol: ' . $payment->variable_symbol . "\n\n";
        if ($payment->status == 'complete') {
            $text .= 'Platba byla spárována s objednávkou ' . $payment->variable_symbol . "\n\n";
        } else {
            $text .= 'Platba nebyla spárována se žádnou objednávkou. Kontaktujte nás prosím co nejdříve' . "\n\n";
        }
        $text .= 'Děkujeme';

        $html = $text;

        return (new MailMessage)
            ->view([
                'html' => 'vendor.notifications.email',
                'text' => 'vendor.notifications.email-text'
            ],
                [
                    'plainText' => $text
                ]
            )
            ->subject('Potvrzení platby')
            ->line($html);
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
