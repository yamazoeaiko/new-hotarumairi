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

class ChatController extends Controller
{
    public function getChatList(){
        $user_id = Auth::id();

        $items = Apply::whereHas('hotaru_request', function ($query) use ($user_id) {
            $query->where('request_user_id', $user_id);
        })->orWhere('apply_user_id', $user_id)->get();
        
        foreach($items as $item){
            $request = HotaruRequest::where('id', $item->request_id)->first();
            
            $host = UserProfile::where('user_id', $request->request_user_id)->first();

            $apply = UserProfile::where('user_id', $item->apply_user_id)->first();

            if($item->apply_user_id == $user_id){
                $item->your_name = $host->nickname;
                $item->profile_img = $host->img_url;
                $item->your_id = $host->user_id;
            }else{
                $item->your_name = $apply->nickname;
                $item->profile_img = $apply->img_url;
                $item->your_id = $apply->user_id;
            };


            $plan = Plan::where('id',$request->plan_id)->first();
            $item->plan_name = $plan->name;
        }
        return view('chat.list', compact('items'));
    }

    public function getChatRoom($apply_id, $your_id){
        $user_id = Auth::id();

        $you = UserProfile::where('user_id', $your_id)->first();

        //チャット内容の表示
        $chats = Chat::where('apply_id', $apply_id)->get();
        foreach ($chats as $chat) {
            $from_user = UserProfile::where('user_id', $chat->from_user)->first();
            $chat->nickname = $from_user->nickname;
            $chat->img_url = $from_user->img_url;
        }
        return view('chat.room', compact('chats','you','apply_id', 'user_id'));
    }

    public function sendChat(Request $request){
        $create_chat = new Chat();
        $create_chat->create([
            'apply_id'=> $request->apply_id,
            'from_user'=>$request->user_id,
            'message'=> $request->message
        ]);

        return redirect()->route('chat.room', ['apply_id' => $request->apply_id, 'your_id'=> $request->your_id]);
    }

    /////////////////////////////////////////
    //サービスに関するチャット
    public function serviceRoom($service_id){
        
    }
}
