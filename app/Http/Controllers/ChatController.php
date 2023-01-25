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
            $item->host_name = $host->nickname;

            $apply = UserProfile::where('user_id', $item->apply_user_id)->first();
            $item->apply_name = $apply->nickname;

            if($item->apply_user_id == $user_id){
                $you = $host;
            }else{
                $you = $apply;
            };

            $plan = Plan::where('id',$request->plan_id)->first();
            $item->plan_name = $plan->name;

            $item->profile_img = $you->img_url;
        }
        return view('chat.list', compact('items','you'));
    }

    public function getChatRoom($apply_id){
        return view('chat.room');
    }
}
