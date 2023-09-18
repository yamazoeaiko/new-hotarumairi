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
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Notifications\ConsultReceive;

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

        //メール通知
        $sender = User::where('id', $sell_user)->first();
        $senderName = $sender->nickname;

        $receiver = User::where('id', $buy_user)->first();
        $receiverName = $receiver->nickname;
        $chatRoom = $room->id;

        $receiver->notify(new ConsultReceive($senderName, $receiverName, $chatRoom));

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
        $chat->message = '見積もりの提案をしました。';
        $chat->save();
 
        return redirect()->route('chat.room',['room_id' => $room->id]);
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
                $entried->gender = '未設定';
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

    

    

    ///////////出品サービスがわ//////////////
    public function serviceConsult(Request $request){
        $entry = new Entry();
        $buy_user = Auth::id();
        $sell_user = $request->sell_user;
        $service_id = $request->service_id;

        $entry->service_id = $service_id;
        $entry->buy_user = $buy_user;
        $entry->sell_user = $sell_user;
        $entry->status = 'pending';
        $entry->save();

        //チャットルームが存在するか確認
        $room = ChatRoom::where('service_id', $service_id)->where('buy_user', $buy_user)->where('sell_user', $sell_user)->first();
        if ($room === null) {
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
        $chat->sender_id = Auth::id();
        $chat->receiver_id = $sell_user;
        $chat->message = $request->first_chat;
        $chat->save();

        //メール通知
        $sender = User::where('id', $buy_user)->first();
        $senderName = $sender->nickname;

        $receiver = User::where('id', $sell_user)->first();
        $receiverName = $receiver->nickname;
        $chatRoom = $room->id;

        $sell_user->notify(new ConsultReceive($senderName, $receiverName, $chatRoom));

        return redirect()->route('chat.list');
    }

    public function serviceEstimate(Request $request){
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();

        $entry->status = 'estimate';
        $entry->save();

        $room = ChatRoom::where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $request->sell_user;
        $chat->receiver_id = $request->buy_user;
        $chat->message = '見積もり提案を送付しました。
        見積もり内容は「出品サービス詳細を確認」からご確認ください。';
        $chat->save();

        return redirect()->route('chat.room', ['room_id' => $room->id]);
    }

    public function serviceEntried($service_id){
        $user_id =Auth::id();
        $service = Service::where('id', $service_id)->first();

        $entrieds = Entry::where('service_id', $service_id)->where('sell_user', $user_id)->get();
        foreach ($entrieds as $entried) {
            $buy_user = User::where('id', $entried->buy_user)->first();
            $entried->user_name = $buy_user->nickname;
            $entried->profile_image = $buy_user->img_url;
            $entried->message = $buy_user->message;
        }

        return view('service.provider.entried',compact('entrieds','service','user_id'));
    }

    public function serviceApprove(Request $request)
    {
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();

        $entry->status = 'approved';
        $entry->save();

        $room = ChatRoom::where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $request->buy_user;
        $chat->receiver_id = $request->sell_user;
        $chat->message = '見積もり提案を承認しました。支払い対応完了までしばらくお待ちください。';
        $chat->save();

        return redirect()->route('chat.room', ['room_id' => $room->id]);
    }

    public function serviceUnapprove(Request $request)
    {
        $entry = Entry::where('id', $request->entry_id)->where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();

        $entry->status = 'unapproved';
        $entry->save();

        $room = ChatRoom::where('service_id', $request->service_id)->where('buy_user', $request->buy_user)->where('sell_user', $request->sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $request->sell_user;
        $chat->receiver_id = $request->buy_user;
        $chat->message = '申し訳ございません。依頼をお断りいたしました。';
        $chat->save();


        return redirect()->route('service.entried', ['service_id' => $request->service_id]);
    }
}
