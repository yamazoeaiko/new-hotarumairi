<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable =[
        'service_id',
        'entry_id',
        'buy_user',
        'sell_user',
        'price',
        'include_tax_price',
        'commission',
        'session_id',
        'payment_intent',
        'cancel_fee'
    ];

    protected $dispatchesEvents = [
        'created' => PaymentCreated::class,
    ];
}

class PaymentCreated
{
    public function __construct(Payment $payment)
    {
        $service = Service::where('id', $payment->service_id)->first();

        $payment_user = User::where('id', $payment->buy_user)->first();
        $receiver_user = User::where('id', $payment->sell_user)->first();

        $announcement_a = new Announcement([
            'title' =>  $payment_user->nickname . 'からお支払いがあります。',
            'description' => $service->main_title . 'の体験イベントに' . $payment_user->nickname . 'さんから支払いがありました。',
            'link' => 'mypage.service.list',
        ]);
        $announcement_a->save();

        $announcementRead_a = new AnnouncementRead([
            'user_id' => $receiver_user->id,
            'announcement_id' => $announcement_a->id,
            'read' => false
        ]);
        $announcementRead_a->save();

        //支払い者へのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $service->main_title . 'のお支払いが完了しました。',
            'description' =>  'お支払い完了です。',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $payment_user->id,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();
    }
}