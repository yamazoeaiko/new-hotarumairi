<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\Delivery;
use App\Models\Agreement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\ChatReceive;
use App\Notifications\BuyerDelivery;
use App\Notifications\SellerDelivery;

class ChatController extends Controller
{
    public function getChatList()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();

        if (ChatRoom::where('buy_user', $user_id)->exists() ) {
            $items = ChatRoom::where('buy_user', $user->id)->get()->filter(function ($item){
                $item->chat = Chat::where('room_id', $item->id)->orderByDesc('created_at')->first();
                return $item->chat;
            })->sortByDesc(function ($item){
                return $item->chat->created_at;
            });
            foreach ($items as $item) {
                $item->user_type ='buy_user';
                $theother = User::where('id', $item->sell_user)->first();
                $item->theother_name = $theother->nickname;
                $item->theother_profile = $theother->img_url;

                $item->create = Chat::where('room_id', $item->id)->orderBy('created_at', 'desc')->pluck('created_at')->first()->format('Y年m月d日 H時i分');

                $service = Service::where('id', $item->service_id)->first();
                $item->service_name = $service->main_title;

                $latest_message = DB::table('chats')
                    ->where('room_id', $item->id)
                    ->orderBy('created_at', 'desc')
                    ->value('message');
                $item->latest_message = Str::limit($latest_message, 60);
                if ($latest_message == null) {
                    $item->latest_message = 'ファイルを送付しました。';
                }

                if(Entry::where('service_id', $item->service_id)->where('buy_user', $user_id)->where('sell_user', $theother->id)->exists()){
                    $entry = Entry::where('service_id', $item->service_id)->where('buy_user', $user_id)->where('sell_user', $theother->id)->first();
                    
                    if($entry->status == 'pending'){
                        $item->entry_status = '相談中';
                    }elseif($entry->status == 'approved'){
                        $item->entry_status = '依頼中';
                    }elseif($entry->status == 'unapproved'){
                        $item->entry_status = '依頼非成立';
                    }elseif($entry->status == 'paid') {
                        $item->entry_status = '支払い対応済み';
                    }elseif($entry->status =='delivered') {
                        $item->entry_status = '納品済み';
                    }
                }else {
                    $item->entry_status = null;
                }
            }
        }else{
            $items = null;
        }

        return view('chat.list_buy', compact('items'));
    }

    public function getChatSellList(){
        $user_id = Auth::id();

        if(ChatRoom::where('sell_user', $user_id)->exists()) {
                $items = ChatRoom::where('sell_user', $user_id)->get()->filter(function ($item){
                    $item->chat = Chat::where('room_id', $item->id)->orderByDesc('created_at')->first();
                    return $item->chat;
                })->sortByDesc(function ($item){
                    return $item->chat->created_at;
                });
                foreach ($items as $item) {
                    $item->user_type ="sell_user";
                    $theother = User::where('id', $item->buy_user)->first();
                    $item->theother_name = $theother->nickname;
                    $item->theother_profile = $theother->img_url;

                    $item->create = Chat::where('room_id', $item->id)->orderBy('created_at', 'desc')->pluck('created_at')->first()->format('Y年m月d日 H時i分');

                    $latest_message = DB::table('chats')
                        ->where('room_id', $item->id)
                        ->orderBy('created_at', 'desc')
                        ->value('message');
                    $item->latest_message = Str::limit($latest_message, 60);
                    if ($latest_message == null) {
                        $item->latest_message = 'ファイルを送付しました。';
                    }

                    $service = Service::where('id', $item->service_id)->first();
                    $item->service_name = $service->main_title;

                    if (Entry::where('service_id', $item->service_id)->where('sell_user', $user_id)->where('buy_user', $theother->id)->exists()) {
                        $entry = Entry::where('service_id', $item->service_id)->where('sell_user', $user_id)->where('buy_user', $theother->id)->first();

                        if ($entry->status == 'pending') {
                            $item->entry_status = '相談中';
                        } elseif ($entry->status == 'approved') {
                            $item->entry_status = '依頼中';
                        } elseif ($entry->status == 'unapproved') {
                            $item->entry_status = '依頼非成立';
                        } elseif ($entry->status == 'paid') {
                            $item->entry_status = '支払い対応済み';
                        } elseif ($entry->status == 'delivered') {
                            $item->entry_status = '納品済み';
                        }
                    } else {
                        $item->entry_status = null;
                    }
                }
            }else {
                $items =null;
            }

        return view('chat.list_sell', compact('items'));    
    }

    public function getChatRoom($room_id)
    {
        $user_id = Auth::id();
        $room = ChatRoom::where('id', $room_id)->first();
        $service = Service::where('id', $room->service_id)->first();

        if($user_id == $room->buy_user) {
            $theother_id = $room->sell_user;
            $mytype = 'buy_user';
        }else {
            $mytype = 'sell_user';
            $theother_id = $room->buy_user;
        }

        $theother = User::where('id', $theother_id)->first();

        if (Entry::where('service_id', $service->id)->where('sell_user', $user_id)->where('buy_user', $theother_id)->exists()) {
            $entry = Entry::where('service_id', $service->id)->where('sell_user', $user_id)->where('buy_user', $theother->id)->first();
        }else {
            $entry = Entry::where('service_id', $service->id)->where('buy_user', $user_id)->where('sell_user', $theother->id)->first();
        }
        if ($entry->status == 'pending') {
            $entry->status_name = '相談中';
        } elseif ($entry->status == 'evaluated') {
            $entry->status_name = '評価済み';
        } elseif ($entry->status == 'unapproved') {
            $entry->status_name = '見積もりを否認';
        } elseif ($entry->status == 'paid') {
            $entry->status_name = '支払い済み';
        } elseif ($entry->status == 'delivered') {
            $entry->status_name = '納品済み';
        } elseif ($entry->status == 'estimate') {
            $entry->status_name = '見積もり提案中';
        }elseif ($entry->status == 'closed'){
            $entry->status_name = 'クローズド';
        }

        //チャット内容の表示
        $chats = Chat::where('room_id', $room_id)->get();
        foreach ($chats as $chat) {
            $sender = User::where('id', $chat->sender_id)->first();
            $chat->nickname = $sender->nickname;
            $chat->img_url = $sender->img_url;
        }

        $agreement = null;
        if(Agreement::where('service_id', $service->id)->where('entry_id', $entry->id)->exists()){
            $agreement = Agreement::where('service_id', $service->id)->where('entry_id', $entry->id)->first();
        }

        $delivery = Delivery::where('entry_id', $entry->id)
        ->where('room_id', $room->id)
        ->first();


        return view('chat.room', compact('chats', 'theother', 'room_id', 'user_id', 'service','room', 'entry', 'mytype', 'agreement', 'delivery'));
    }

    public function offerDelivery(Request $request){
        $entry = Entry::where('id', $request->entry_id)->first();
        $entry->status = 'delivery_pending';
        $entry->save();

        $delivery = new Delivery();
        $delivery->entry_id = $entry->id;
        $delivery->room_id = $request->room_id;
        $delivery->message = $request->message;
        $delivery->save();

        //購入者への納品報告Notification
        $buyer = User::where('id', $entry->buy_user)->first();
        $buyer->notify(new BuyerDelivery());

        return redirect()->back();
    }

    public function approvedDelivery(Request $request){
        $entry = Entry::where('id', $request->entry_id)->first();
        $entry->status = 'delivery_complete';
        $entry->save();

        //出品者への納品報告Notification
        $seller = User::where('id', $entry->sell_user)->first();
        $seller->notify(new SellerDelivery());

        return redirect()->back();
    }

    public function unapprovedDelivery(Request $request)
    {
        $entry = Entry::where('id', $request->entry_id)->first();
        $entry->status = 'paid';
        $entry->save();

        $delivery = Delivery::where('entry_id', $request->entry_id)->first();
        $delivery->delete();

        return redirect()->back();
    }

    public function sendChat(Request $request)
    {
        if (is_null($request->input('message')) && !$request->hasFile('file_path')) {
            return redirect()->back()->with('error', 'メッセージまたは画像を選択してください。');
        }

        $chat = new Chat;
        $chat->room_id = $request->room_id;
        $chat->sender_id = Auth::id();
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->input('message');

        // 画像ファイルを保存する処理
        if ($request->hasFile('file_path')) {
            $dir = 'in_chat';
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $filename);
            $chat->file = 'storage/in_chat/' . $filename;
        }

        $chat->save();

        //Notification飛ばす
        $user = User::where('id', $request->receiver_id)->first();
        $user->notify(new ChatReceive());

        return redirect()->back();
    }

    /////////////////////////////////////////
    //サービスに関するチャット
    public function serviceRoom($service_id)
    {
    }
}
