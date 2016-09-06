<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderConfirmation extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
        $order = $this->order;

        $text = 'Děkujeme za Vaši objednávku prostoru.' . "\n\n";
        $text .= 'Rekapitulace:' . "\n\n";
        $text .= 'Velikost prostoru: ' . formatBytes($order->ordered_size) . "\n";
        $text .= 'Perioda obnovování: ' . trans('message.order.period.' . $order->period) . "\n";
        $text .= 'Cena: ' . $order->price_per_period . ',- Kč' . "\n";
        $text .= 'Variabilní symbol: ' . $order->variable_symbol . "\n";
        $text .= 'Číslo účtu: 2301045287/2010' . "\n\n";
        $text .= 'Platbu prosím uhraďte co nejdříve:' . "\n\n";
        $text .= 'Pokud si přejete daňový doklad, napište prosím své fakturační údaje jako odpověď na tento email.';

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
            ->subject('Potvrzení objednávky')
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
