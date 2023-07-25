<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChatReceive extends Notification
{
    use Queueable;

    private $receiveMessage;
    private $senderName;
    private $receiverName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($receiveMessage, $senderName, $receiverName)
    {
        $this->receiveMessage = $receiveMessage;
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
            ->subject('ほたる参り　チャットが届きました')
            ->markdown('mail.chat_receive',[
                'receiveMessage' => $this->receiveMessage,
            'senderName' => $this->senderName,
            'receiverName' => $this->receiverName
            ]
        );
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
