<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerCancelAgreement extends Notification
{
    use Queueable;

    private $sellerName;
    private $buyerName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sellerName, $buyerName)
    {
        $this->sellerName = $sellerName;
        $this->buyerName = $buyerName;
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
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('【ほたる参り】' . $this->sellerName . 'さまがサービスのキャンセル申請をしました')
            ->markdown('mail.buyer_cancel_agreement', [
                'sellerName' => $this->sellerName,
                'buyerName' => $this->buyerName
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
