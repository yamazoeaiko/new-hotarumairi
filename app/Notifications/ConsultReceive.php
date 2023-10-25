<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsultReceive extends Notification
{
    use Queueable;
    private $senderName;
    private $receiverName;
    private $chatRoom;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($senderName, $receiverName, $chatRoom)
    {
        $this->senderName = $senderName;
        $this->receiverName = $receiverName;
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
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('【ほたる参り】チャットが届きました')
            ->markdown('mail.consult_receive',[
                'senderName'=> $this->senderName,
                'receiverName'=> $this->receiverName,
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
