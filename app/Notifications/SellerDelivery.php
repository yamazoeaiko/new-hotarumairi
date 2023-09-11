<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerDelivery extends Notification
{
    use Queueable;

    private $buyerName;
    private $sellerName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($buyerName, $sellerName)
    {
        $this->buyerName = $buyerName;
        $this->sellerName = $sellerName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS', 'ほたる参り <info@hotarumairi.com>'))
            ->subject('【ほたる参り】' . $this->buyerName . 'さまから納品の受諾が届きました。')
            ->markdown('mail.seller_delivery', [
                'buyerName' => $this->buyerName,
                'sellerName' => $this->sellerName
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
