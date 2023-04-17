<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'sender_id',
        'receiver_id',
        'message',
        'file',
        'link_path',
        'compact',
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'created' => ChatCreated::class,
    ];
}

class ChatCreated
{
    public function __construct(Chat $chat)
    {
        $sender_user = User::where('id', $chat->sender_id)->first();
        $receiver_user = User::where('id', $chat->receiver_id)->first();

        $announcement = new Announcement([
            'title' =>  $sender_user->nickname.'からのメッセージがあります。',
            'description' => 'チャットを確認し、必要な対応を行って下さい。',
            'link' => 'chat.list',
        ]);
        $announcement->save();

        $announcementRead = new AnnouncementRead([
            'user_id' => $chat->receiver_id,
            'announcement_id' => $announcement->id,
            'read' => false
        ]);
        $announcementRead->save();
    }
}
