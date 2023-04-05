<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\ServiceConsult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function getChatList()
    {
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();

        if (ChatRoom::where('buy_user', $user_id)->exists() ) {
            $items = ChatRoom::where('buy_user', $user->id)->get();
            foreach ($items as $item) {
                $item->user_type ='buy_user';
                $theother = User::where('id', $item->sell_user)->first();
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

                if(Entry::where('service_id', $item->service_id)->where('buy_user', $user_id)->where('sell_user', $theother->id)->exists()){
                    $entry = Entry::where('service_id', $item->service_id)->where('buy_user', $user_id)->where('sell_user', $theother->id)->first();
                    
                    if($entry->status == 'pending'){
                        $item->status = '相談中';
                    }elseif($entry->status == 'approved'){
                        $item->status = '依頼中';
                    }elseif($entry->status == 'unapproved'){
                        $item->status = '依頼非成立';
                    }elseif($entry->status == 'paid') {
                        $item->status = '支払い対応済み';
                    }elseif($entry->status =='delivered') {
                        $item->status = '納品済み';
                    }
                }else {
                    $item->status = null;
                }
            }
        } elseif (ChatRoom::where('sell_user', $user_id)->exists()) {
                $items = ChatRoom::where('sell_user', $user_id)->get();
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
                            $item->status = '相談中';
                        } elseif ($entry->status == 'approved') {
                            $item->status = '依頼中';
                        } elseif ($entry->status == 'unapproved') {
                            $item->status = '依頼非成立';
                        } elseif ($entry->status == 'paid') {
                            $item->status = '支払い対応済み';
                        } elseif ($entry->status == 'delivered') {
                            $item->status = '納品済み';
                        }
                    } else {
                        $item->status = null;
                    }
                }
            }else{
                $items = null;
            }
        return view('chat.list', compact('items'));
    }

    public function getChatRoom($room_id)
    {
        $user_id = Auth::id();
        $room = ChatRoom::where('id', $room_id)->first();
        $service_id = Service::where('id', $room->service_id)->pluck('id')->first();

        if($user_id == $room->buy_user) {
            $theother_id = $room->sell_user;
        }else {
            $theother_id = $room->buy_user;
        }

        $theother = User::where('id', $theother_id)->first();

        //チャット内容の表示
        $chats = Chat::where('room_id', $room_id)->get();
        foreach ($chats as $chat) {
            $sender = User::where('id', $chat->sender_id)->first();
            $chat->nickname = $sender->nickname;
            $chat->img_url = $sender->img_url;
        }

        return view('chat.room', compact('chats', 'theother', 'room_id', 'user_id', 'service_id'));
    }

    public function sendChat(Request $request)
    {
        if (is_null($request->input('message')) && !$request->hasFile('image')) {
            return redirect()->back()->with('error', 'メッセージまたは画像を選択してください。');
        }

        $chat = new Chat;
        $chat->room_id = $request->room_id;
        $chat->sender_id = Auth::id();
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->input('message');

        // 画像ファイルを保存する処理
        if ($request->hasFile('image')) {
            $dir = 'in_chat';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $filename);
            $chat->image = 'storage/in_chat/' . $filename;
        }

        $chat->save();
        return redirect()->back();
    }

    /////////////////////////////////////////
    //サービスに関するチャット
    public function serviceRoom($service_id)
    {
    }
}
