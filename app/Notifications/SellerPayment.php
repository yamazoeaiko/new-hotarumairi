<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerPayment extends Notification
{
    use Queueable;

    private $serviceName;
    private $buyerName;
    private $sellerName;
    private $Price;
    private $paymentDate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($serviceName, $buyerName, $sellerName, $Price, $paymentDate)
    {
        $this->serviceName = $serviceName;
        $this->buyerName = $buyerName;
        $this->sellerName = $sellerName;
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
        ->from(env('MAIL_FROM_ADDRESS', 'info@hotarumairi.com'))
        ->subject('【ほたる参り】'.$this->buyerName.'様があなたのサービスが購入されました')
        ->markdown('mail.seller_payment',[
            'serviceName' => $this->serviceName,
            'buyerName' => $this->buyerName,
            'sellerName' => $this->sellerName,
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
