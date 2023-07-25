<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\Agreement;
use App\Models\Payment;
use App\Models\Cancel;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Notifications\sendAgreement;
use App\Notifications\BuyerPayment;
use App\Notifications\SellerPayment;
use App\Notifications\CancelAgreement;
use App\Notifications\BuyerCancelAgreement;

class AgreementController extends Controller
{
    public function index($agreement_id){
        $item = Agreement::where('id', $agreement_id)->first();
        $entry = Entry::where('id', $item->entry_id)->first();
        $item->status = $entry->status;

        $user_id = Auth::id();
        if($user_id == $item->buy_user){
            $mytype = 'buy_user';
        }elseif($user_id == $item->sell_user){
            $mytype = 'sell_user';
        }

        return view('agreement.index', compact('item', 'mytype'));
    }

    public function create($service_id, $entry_id){
        $user_id = Auth::id();
        $service = Service::where('id', $service_id)->first();
        $entry = Entry::where('id', $entry_id)->first();
        
        return view('agreement.create',compact('service','entry', 'user_id'));
    }

    public function done(Request $request){
        $agreement = new Agreement();
        $agreement->buy_user = $request->buy_user;
        $agreement->sell_user = $request->sell_user;
        $agreement->service_id = $request->service_id;
        $agreement->entry_id = $request->entry_id;
        $agreement->main_title = $request->main_title;
        $agreement->content = $request->content;
        $agreement->price = $request->price;
        $agreement->price_net = $request->price*0.9;
        $agreement->delivery_deadline = $request->delivery_deadline;
        $agreement->free = $request->free;
        $agreement->status = 'pending';
        $agreement->save();

        $room = ChatRoom::where('service_id', $agreement->service_id)->where('buy_user', $agreement->buy_user)->where('sell_user', $agreement->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $agreement->sell_user;
        $chat->receiver_id = $agreement->buy_user;
        $chat->message = 'お見積もりを提案しました。';
        $chat->save();

        $buy_user = User::where('id', $agreement->buy_user)->first();

        
        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $agreement->main_title . 'の見積書が提案されました。',
            'description' =>  '見積もり確認ください。',
            'link' => 'chat.list'
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        //Notification飛ばす
        $user = User::where('id', $request->buy_user)->first();
        $receiverName = $user->nickname;
        $sender = User::where('id', $agreement->sell_user)->first();
        $senderName = $sender->nickname;
        $user->notify(new sendAgreement($receiverName, $senderName));

        return redirect()->route('chat.room', ['room_id' => $room->id]);
    }

    public function edit($agreement_id){
        $item = Agreement::where('id', $agreement_id)->first();
        return view('agreement.edit', compact('item'));
    }

    public function update(Request $request){
        $agreement = Agreement::where('id', $request->agreement_id)->first();
        $agreement->main_title = $request->main_title;
        $agreement->content = $request->content;
        $agreement->price = $request->price;
        $agreement->delivery_deadline = $request->delivery_deadline;
        $agreement->free = $request->free;
        $agreement->save();

        return redirect()->route('agreement.index', ['agreement_id' => $agreement->id]);
    }

    //支払い画面
    public function payment($agreement_id)
    {
        $agreement = Agreement::where('id', $agreement_id)->first();
        $entry = Entry::where('id', $agreement->entry_id)->first();
        $service = Service::where('id', $agreement->service_id)->first();

        $sell_user = User::where('id', $agreement->sell_user)->first();

        $include_tax_price = $agreement->price * 1.1; //課税

        //stripe処理//
        $publicKey = config('payment.stripe_public_key');
        // 1. Stripeライブラリの初期化（サーバサイド）
        \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));

        $secretKey = new \Stripe\StripeClient(\Config::get('payment.stripe_secret_key'));
        //支払いフォームを構築するリクエストをStripe APIに送信する
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $include_tax_price,
                    'product_data' => [
                        'name' => $agreement->main_title,
                    ],
                ],
                'quantity' => '1',
            ]],
            'mode' => 'payment',

            'success_url'          =>  route('payment.success', ['agreement_id' => $agreement->id]),
            'cancel_url'           => route('agreement.index', ['agreement_id' => $agreement->id])
        ]);

        $agreement->session_id = $session->id;
        $agreement->save();

        $agreement->main_title = $service->main_title;
        $agreement->sell_user = $sell_user->nickname;
        $agreement->include_tax_price = $include_tax_price;

        return view('payment.index', compact('agreement', 'session', 'publicKey'));
    }

    public function successPayment($agreement_id)
    {
        $user_id = Auth::id();
        $agreement = Agreement::where('id', $agreement_id)->first();
        $agreement->status = 'paid';
        $agreement->save();

        $entry = Entry::where('id', $agreement->entry_id)->first();
        $entry->status = 'paid';
        $entry->save();
        $service = Service::where('id', $entry->service_id)->first();

        $sell_user = User::where('id', $agreement->sell_user)->first();
        $price = $agreement->price;
        $tax = $agreement->price * 0.1;
        $include_tax_price = $price * 1.1;
        $commission = $price * 0.1;

        $stripe = new \Stripe\StripeClient(\Config::get('payment.stripe_secret_key'));
        $session = $stripe->checkout->sessions->retrieve($agreement->session_id);

        $payment = new Payment();
        $payment->service_id = $service->id;
        $payment->entry_id = $entry->id;
        $payment->agreement_id = $agreement->id;
        $payment->sell_user = $agreement->sell_user;
        $payment->buy_user = $agreement->buy_user;
        $payment->price = $price;
        $payment->include_tax_price = $include_tax_price;
        $payment->commission = $commission;
        $payment->session_id = $session->id;
        $payment->payment_intent = $session->payment_intent;
        $payment->transfer = 'unapplied';
        $payment->save();

        $room = ChatRoom::where('service_id', $service->id)->where('buy_user', $agreement->buy_user)->where('sell_user', $agreement->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $agreement->buy_user;
        $chat->receiver_id = $agreement->sell_user;
        $chat->message = '支払い対応が完了しました。';
        $chat->save();

        $buy_user = User::where('id', $agreement->buy_user)->first();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $buy_user->nickname . 'からお支払いがあります。',
            'description' => $agreement->main_title . 'に' . $buy_user->nickname . 'さんから支払いがありました。',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_a = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_a->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $agreement->main_title . 'のお支払いが完了しました。',
            'description' =>  'お支払い完了です。',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        $buyerName = $buy_user->nickname;
        $sellerName = $sell_user->nickname;
        $serviceName = $service->main_title;
        $Price = $payment->price;
        $paymentDate = $payment->created_at;
        //buyerへの支払い完了Notification④
        $buy_user->notify(new BuyerPayment($buyerName, $sellerName, $serviceName, $Price, $paymentDate));

        //sellerへの支払い完了Notification③
        $sell_user->notify(new SellerPayment($buyerName, $sellerName, $serviceName, $Price, $paymentDate));


        return view('payment.success', compact('agreement','room'));
    }

    public function unapproved(Request $request){
        $agreement = Agreement::where('id', $request->agreement_id)->first();
        $entry = Entry::where('id', $agreement->entry_id)->first();

        $buy_user = User::where('id', $agreement->buy_user)->first();
        $sell_user = User::where('id', $agreement->sell_user)->first();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $buy_user->nickname . 'が'.$agreement->main_title. 'の見積り提案を辞退しました',
            'description' => $agreement->main_title . '見積もり辞退です',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_a = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_a->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $agreement->main_title . 'の見積もり提案を辞退しました',
            'description' =>  '見積もり辞退',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        $agreement->delete();
        $entry->status = 'pending';
        $entry->save();

        return redirect()->route('chat.list');
    }

    public function cancel(Request $request){
        $agreement = Agreement::where('id', $request->agreement_id)->first();
        $entry = Entry::where('id', $agreement->entry_id)->first();

        $buy_user = User::where('id', $agreement->buy_user)->first();
        $sell_user = User::where('id', $agreement->sell_user)->first();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $agreement->main_title . 'の'.$buy_user->nickname.'に提案中の見積もりを取り下げました',
            'description' => $agreement->main_title . '見積もり取り下げです',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_a = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_a->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $agreement->main_title . 'の見積もり提案が取り下げられました',
            'description' =>  '見積もり取り下げ',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        $agreement->delete();
        $entry->status = 'pending';
        $entry->save();

        return redirect()->route('chat.list');

    }

    public function buyerCancel($entry_id, $agreement_id) {
        $entry = Entry::where('id', $entry_id)->first();
        $item = Agreement::where('id', $agreement_id)->first();
        $payment = Payment::where('entry_id', $entry_id)->where('agreement_id', $agreement_id)->first();
        $user_id = Auth::id();
        $item->include_tax_price = $payment->include_tax_price;
        $item->create = $payment->created_at;
        $item->entry_id = $entry->id;
        $item->payment_id = $payment->id;

        return view('payment.cancel_buyer', compact('item'));
    }

    public function sellerCancel($entry_id, $agreement_id)
    {
        $entry = Entry::where('id', $entry_id)->first();
        $item = Agreement::where('id', $agreement_id)->first();
        $payment = Payment::where('entry_id', $entry_id)->where('agreement_id', $agreement_id)->first();
        $user_id = Auth::id();
        $item->include_tax_price = $payment->include_tax_price;
        $item->create = $payment->created_at;
        $item->entry_id = $entry->id;
        $item->payment_id = $payment->id;

        $sell_user = User::where('id', $user_id)->first();
        $sellerName =$sell_user->nickname;
        $buy_user = User::where('id', $entry->buy_user)->first();
        $buyerName = $buy_user->nickname;
        //出品者のキャンセルNotification（出品者側への通知）
        $sell_user->notify(new CancelAgreement($sellerName, $buyerName));

        //購入者側への通知
        $buy_user->notify(new BuyerCancelAgreement($sellerName, $buyerName));

        return view('payment.cancel_seller', compact('item'));
    }

    public function cancelBuyerOffer(Request $request){
        $entry = Entry::where('id', $request->entry_id)->first();
        $agreement = Agreement::where('id', $request->agreement_id)->first();

        $entry->status = 'cancel_pending';
        $entry->save();
        $agreement->status = 'cancel_pending';
        $agreement->save();

        $buy_user = User::where('id', $agreement->buy_user)->first();

        $payment = Payment::where('entry_id', $entry->id)->where('agreement_id', $agreement->id)->where('buy_user', $buy_user->id)->first();

        $cancel = new Cancel();
        $cancel->status = 'pending';
        $cancel->payment_id = $payment->id;
        $cancel->agreement_id = $agreement->id;
        $cancel->save();


        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $buy_user->nickname . 'が'.$agreement->main_title.'のキャンセルを申請しました',
            'description' =>  'キャンセル内容の確認をしてください',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_s = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_s->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>   $agreement->main_title . 'のキャンセル申請を受け付けました。',
            'description' =>  '管理者が確認中です',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        //管理者へのメッセージ
        $announcement_admin = new Announcement([
            'title' =>  $buy_user->nickname . 'から' . $agreement->main_title . 'のキャンセル申請があります。',
            'description' =>  '管理者が確認中です',
            'link' => 'admin.cancel.offer.list',
        ]);
        $announcement_admin->save();

        $announcementRead_admin = new AnnouncementRead([
            'user_id' => 1,
            'announcement_id' => $announcement_admin->id,
            'read' => false
        ]);
        $announcementRead_admin->save();

        return redirect()->route('agreement.index',['agreement_id'=>$agreement->id]);
    }

    public function cancelSellerOffer(Request $request)
    {
        $entry = Entry::where('id', $request->entry_id)->first();
        $agreement = Agreement::where('id', $request->agreement_id)->first();

        $entry->status = 'cancel_pending';
        $entry->save();
        $agreement->status = 'cancel_pending';
        $agreement->save();

        $buy_user = User::where('id', $agreement->buy_user)->first();
        $sell_user = User::where('id', $agreement->sell_user)->first();

        $payment = Payment::where('entry_id', $entry->id)->where('agreement_id', $agreement->id)->where('buy_user', $buy_user->id)->first();

        $cancel = new Cancel();
        $cancel->status = 'pending';
        $cancel->payment_id = $payment->id;
        $cancel->agreement_id = $agreement->id;
        $cancel->save();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $agreement->main_title . 'のキャンセル申請を受け付けました',
            'description' =>  '管理者確認中です',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_s = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_s->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>  $sell_user->nickname.'さんが'. $agreement->main_title . 'のキャンセル申請をしました。',
            'description' =>  '管理者が確認中です',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        //管理者へのメッセージ
        $announcement_admin = new Announcement([
            'title' =>  $sell_user->nickname . 'から' . $agreement->main_title . 'のキャンセル申請があります。',
            'description' =>  '管理者が確認中です',
            'link' => 'admin.cancel.offer.list',
        ]);
        $announcement_admin->save();

        $announcementRead_admin = new AnnouncementRead([
            'user_id' => 1,
            'announcement_id' => $announcement_admin->id,
            'read' => false
        ]);
        $announcementRead_admin->save();

        return redirect()->route('agreement.index', ['agreement_id' => $agreement->id]);
    }
}
