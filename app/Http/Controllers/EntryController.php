<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\Entry;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Favorite;
use App\Models\Follow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Illuminate\Support\Str;

class EntryController extends Controller
{
    public function sendOffer(Request $request)
    {
        $entry = new Entry();
        $sell_user = Auth::id();
        $buy_user = $request->buy_user;
        $service_id = $request->service_id;

        $entry->service_id = $service_id;
        $entry->buy_user = $buy_user;
        $entry->sell_user = $sell_user;
        $entry->status = 'pending';
        $entry->save();

        //チャットルームが存在するか確認
        $room = ChatRoom::where('service_id', $service_id)->where('buy_user', $buy_user)->where('sell_user', $sell_user)->first();
        if($room === null){
            $room = new ChatRoom();
            $room->service_id = $service_id;
            $room->buy_user = $buy_user;
            $room->sell_user = $sell_user;
            $room->save();
        }
        //Chatモデルへ反映させる
        $room = ChatRoom::where('service_id', $service_id)->where('buy_user', $buy_user)->where('sell_user', $sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $sell_user;
        $chat->receiver_id = $buy_user;
        $chat->message = $request->first_chat;
        $chat->save();

        return redirect()->route('chat.list');
    }

    public function postEstimate(Request $request) {
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();

        $entry->status = 'estimate';
        $entry->save();

        $room = ChatRoom::where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $request->sell_user;
        $chat->receiver_id = $request->buy_user;
        $chat->message = '正式な応募が完了しました。';
        $chat->save();
 
        return redirect()->route('search.more',['service_id' => $request->service_id]);
    }

    public function pubreqEntried($service_id){
        $user_id = Auth::id();
        $service = Service::where('id', $service_id)->first();

        $entrieds = Entry::where('service_id', $service_id)
            ->where('buy_user', $user_id)
            ->whereNotIn('status', ['pending'])
            ->get();


        foreach ($entrieds as $entried) {
            $entried_user = User::where('id', $entried->sell_user)->first();
            $entried->user_name = $entried_user->nickname;
            $entried->profile_image = $entried_user->img_url;
            $entried->message = $entried_user->message;
            $entried->gender = '男性';
            if ($entried_user->gender == '2') {
                $entried->gender = '女性';
            } elseif ($entried_user->gender == '3') {
                $entried->gender = 'その他';
            }
        }

        return view('public_request.entried', compact('entrieds', 'user_id', 'service'));
    }

    public function pubreqApprove(Request $request){
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();
        
        $entry->status ='approved';
        $entry->save();

        return redirect()->route('pubreq.entried',['service_id' => $request->service_id]);
    }

    public function pubreqUnapprove(Request $request)
    {
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();

        $entry->status = 'unapproved';
        $entry->save();

        return redirect()->route('pubreq.entried', ['service_id' => $request->service_id]);
    }

    //支払い画面
    public function payment($entry_id)
    {
        $entry = Entry::where('id', $entry_id)->first();
        $service = Service::where('id', $entry->service_id)->first();

        $sell_user = User::where('id', $service->sell_user)->first();


        $price = $service->price*1.1;//課税

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
                    'unit_amount' => $price,
                    'product_data' => [
                        'name' => $service->main_title,
                    ],
                ],
                'quantity' => '1',
            ]],
            'mode' => 'payment',

            'success_url'          =>  route('payment.success', ['entry_id' => $entry->id]),
            'cancel_url'           => route('pubreq.entried', ['service_id' => $entry->service_id])
        ]);

        $entry->session_id = $session->id;
        $entry->save();

        $entry->service_name = $service->main_title;
        $entry->sell_user = $sell_user->nickname;
        $entry->include_tax_price = $price;

        return view('payment.index', compact('entry', 'session', 'publicKey'));
    }
}
