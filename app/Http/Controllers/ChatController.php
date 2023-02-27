<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HotaruRequest;
use App\Models\Confirm;
use App\Models\Apply;
use App\Models\UserProfile;
use App\Models\Plan;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Service;
use App\Models\ServiceConsult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function getChatList(){
        $user_id = Auth::id();
        $items = ChatRoom::select('chat_rooms.*', DB::raw('MAX(chats.created_at) as latest_chat_date'))
        ->leftJoin('chats', 'chat_rooms.id', '=', 'chats.room_id')
        ->where('user_id_one', $user_id)
            ->orWhere('user_id_another', $user_id)
            ->groupBy('chat_rooms.id')
            ->orderBy('latest_chat_date', 'desc')
            ->get();

        foreach($items as $item){
            if($item->user_id_one == $user_id){
                $theother =UserProfile::where('id', $item->user_id_another)->first();
                $item->theother_name = $theother->nickname;
                $item->theother_profile = $theother->img_url;
                $item->theother_id = $theother->user_id;
            }else{
                $theother = UserProfile::where('id',$item->user_id_one)->first();
                $item->theother_name = $theother->nickname;
                $item->theother_profile = $theother->img_url;
                $item->theother_id = $theother->user_id;
            }
            $item->create = Chat::where('room_id',$item->id)->orderBy('created_at', 'desc')->pluck('created_at')->first()->format('Y年m月d日 H時i分');

            $latest_message = DB::table('chats')
                ->where('room_id', $item->id)
                ->orderBy('created_at', 'desc')
                ->value('message');
            $item->latest_message = Str::limit($latest_message, 60);
            if ($latest_message == null) {
                $item->latest_message = 'ファイルを送付しました。';
            }
        }


        return view('chat.list', compact('items'));
    }

    public function getChatRoom($room_id, $theother_id){
        $user_id = Auth::id();

        $theother = UserProfile::where('user_id', $theother_id)->first();

        $chat_room =ChatRoom::where('id', $room_id)->first();

        if($chat_room->apply_id){
        $apply = Apply::where('id', $chat_room->apply_id)->first();
        $hotaru_request_id = $apply->request_id;
        }else{
            $hotaru_request_id = null;
        }

        if($chat_room->consult_id !== null){
            $consult = ServiceConsult::where('id', $chat_room->consult_id)->first();
            $service_id = $consult->service_id;
        }else{
            $service_id = null;
        }

        //チャット内容の表示
        $chats = Chat::where('room_id', $room_id)->get();
        foreach ($chats as $chat) {
            $from_user = UserProfile::where('user_id', $chat->from_user)->first();
            $chat->nickname = $from_user->nickname;
            $chat->img_url = $from_user->img_url;
        }
        return view('chat.room', compact('chats','theother','room_id', 'user_id', 'chat_room', 'hotaru_request_id', 'service_id'));
    }

    public function sendChat(Request $request){
        if (is_null($request->input('message')) && !$request->hasFile('image')) {
            return redirect()->back()->with('error', 'メッセージまたは画像を選択してください。');
        }

        $chat = new Chat;
        $chat->room_id = $request->room_id;
        $chat->from_user = Auth::id();
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
    public function serviceRoom($service_id){

    }
}
