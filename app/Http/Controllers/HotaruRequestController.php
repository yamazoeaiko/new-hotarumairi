<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Plan;
use App\Models\HotaruRequest;
use App\Models\UserProfile;
use App\Models\Apply;
use App\Models\Chat;
use App\Models\OhakamairiSummary;
use App\Models\SanpaiSummary;
use App\Models\ChatRoom;
use App\Models\Service;
use Illuminate\Support\Arr;

class HotaruRequestController extends Controller
{
    ////ここから仕事を探す関連//////////////////
    ////////////////////////////////////////
    

    public function searchApply(Request $request){
        $apply = new Apply();
        $apply_user_id = Auth::id();
        $theother_id = $request->host_user;

        $apply->create([
            'request_id' => $request->request_id,
            'host_user' => $request->host_user,
            'apply_user_id' => $apply_user_id,
            'first_chat' =>$request->first_chat
        ]);

        // Applyモデルからid取得
        $apply_id = Apply::where('request_id', $request->request_id)->where('apply_user_id', $apply_user_id)->pluck('id')->first();

        $chat_room =
        $apply_user_id < $theother_id ? "$apply_user_id$theother_id" : "$theother_id$apply_user_id";
        $chat_room_id = (int)$chat_room;
        
        if($chat_exist = ChatRoom::where('room_id', $chat_room_id)->first()){
            $room_id = $chat_exist->id;
            $chat_exist->update(['apply_id'=>$apply_id]);
        }else{
            $room = new ChatRoom();
            $room->create([
                'room_id'=>$chat_room_id,
                'apply_id' => $apply_id,
                'user_id_one'=> $apply_user_id,
                'user_id_another' => $theother_id
            ]);
            $room_id = ChatRoom::where('room_id', $chat_room_id)->pluck('id')->first();
        }

        //Chatモデルへ反映させる
        Chat::create([
            'room_id' =>$room_id,
            'message' => $request->first_chat,
            'from_user' => $apply_user_id
        ]);


        return redirect()->route('search.index');
    }

    public function postSearch(Request $request){
        //ポストする検索条件の設定
        $area_id = $request->area_id;
        $plan_id = $request->plan_id;
        $price_max = $request->price_max;
        $price_min = $request->price_min;
        $request->session()->put(
            'search_contents',
            [
                'area_id' => $area_id,
                'plan_id' => $plan_id,
                'price_max' => $price_max,
                'price_min' => $price_min,
            ]
        );

        return redirect()->route('search.index')->withInput();
    }



    /////ここからチャット関連////////////////////////
    /////////////////////////////////////////////
    public function getChat(){
        //
    }
}
