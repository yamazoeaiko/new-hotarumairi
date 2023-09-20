<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerAgreementUnapproved extends Notification
{
    use Queueable;
    private $sellerName;
    private $buyerName;
    private $serviceName;
    private $chatRoom;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sellerName, $buyerName, $serviceName, $chatRoom)
    {
        $this->sellerName = $sellerName;
        $this->buyerName = $buyerName;
        $this->serviceName = $serviceName;
        $this->chatRoom = $chatRoom;
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
        ->subject('【ほたる参り】見積積もり提案が辞退されました')
        ->markdown('mail.seller_agreement_unapproved', [
            'sellerName' => $this->sellerName,
            'buyerName' => $this->buyerName,
            'serviceName' => $this->serviceName,
            'chatRoom' => $this->chatRoom
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
