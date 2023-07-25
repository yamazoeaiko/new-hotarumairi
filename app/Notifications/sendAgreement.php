<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendAgreement extends Notification
{
    use Queueable;

    private $senderName;
    private $receiverName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($receiverName, $senderName)
    {
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
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
            ->subject('【ほたる参り】' . $this->senderName . 'から見積もり提案が届きました。')
            ->markdown('mail.send_agreement', [
                'receiverName' => $this->receiverName,
                'senderName'=> $this->senderName
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
