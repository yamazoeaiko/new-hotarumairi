<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerPayment extends Notification
{
    use Queueable;

    private $buyerName;
    private $sellerName;
    private $serviceName;
    private $Price;
    private $paymentDate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($buyerName, $sellerName, $serviceName, $Price, $paymentDate)
    {
        $this->buyerName = $buyerName;
        $this->sellerName = $sellerName;
        $this->serviceName = $serviceName;
        $this->Price = $Price;
        $this->paymentDate = $paymentDate;
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
            ->subject('【ほたる参り】' . $this->buyerName . 'さまがあなたのサービスを購入されました')
            ->markdown('mail.seller_payment', [
                'buyerName' => $this->buyerName,
                'sellerName' => $this->sellerName,
                'serviceName' => $this->serviceName,
                'Price' => $this->Price,
                'paymentDate' => $this->paymentDate
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
