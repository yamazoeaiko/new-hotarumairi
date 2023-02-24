<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\Gender;
use App\Models\Area;
use App\Models\Plan;
use App\Models\OhakamairiSummary;
use App\Models\SanpaiSummary;
use App\Models\HotaruRequest;
use App\Models\Apply;
use App\Models\Confirm;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceConsult;
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function search(){
        $items = Service::get()->filter(function ($item) {
            return $item->public_sign != false;
        });

        foreach($items as $item){
            $item->categories = ServiceCategory::whereIn('id',$item->category_ids)->get();
            
            foreach($item->categories as $value){
                $data = ServiceCategory::where('id',$value->id)->first();
                $value->category_name = $data->name;
            }

            $user = UserProfile::where('id', $item->user_id)->first();
            $item->user_name = $user->nickname;
            $item->img_url = $user->img_url;

        }

        return view('service.index',
        compact('items'));
    }

    public function showUser($user_id){

    }

    public function showDetail($service_id){
        $item = Service::where('id', $service_id)->first();

        $user = UserProfile::where('id', $item->user_id)->first();
        $item->user_name = $user->nickname;
        $item->img_url = $user->img_url;
        $living = Area::where('id', $user->living_area)->first();
        $item->living_area = $living->name;
        $item->age =
        Carbon::parse($user->birthday)->age;

        if($item->public_sign ==true){
            $item->public = "公開中";
        }else{
            $item->public = "非公開中";
        }

        $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

        foreach ($item->categories as $value) {
            $data = ServiceCategory::where('id', $value->id)->first();
            $value->category_name = $data->name;
        }

        $item->area_ids = Area::whereIn('id', $item->area_id)->get();
        foreach($item->area_ids as $area_id){
            $area = Area::where('id', $area_id->id)->first();
            $area_id->name = $area->name;
        }

        $user_id = Auth::id();

        return view('service.detail',
        compact('item', 'user_id'));
    }

    public function create(){
        $user_id = Auth::id();
        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view('service.create',
    compact('user_id', 'areas', 'categories'));
    }

    public function done(Request $request){
        if($request->public_sign == 1){
            $public = true;
        }else{
            $public = false;
        }
        
        $service = new Service();

        $service->user_id = $request->user_id;
        $service->main_title = $request->main_title;
        $service->content = $request->content;
        $service->category_ids = $request->category_id;
        $service->attention = $request->attention;
        $service->price = $request->price;
        $service->area_id = $request->area_id;
        $service->public_sign = $public;
        $service->save();

        return redirect()->route('mypage.index');
    }

    public function edit($service_id){
        //
    }

    public function update(Request $request){
        //
    }

    public function destroy(Request $request){
        //
    }

    public function sendConsult(Request $request){
        $consult = new ServiceConsult();
        $consulting_user_id = Auth::id();
        $theother_id = $request->host_user;

        $consult->create( [
            'host_user' => $theother_id,
            'service_id' => $request->service_id,
            'consulting_user' => $consulting_user_id,
            'first_chat' => $request->first_chat
        ]);

        $consult_id = ServiceConsult::where('service_id', $request->service_id)->where('consulting_user', $consulting_user_id)->pluck('id')->first();

        $chat_room =
        $consulting_user_id < $theother_id ? "$consulting_user_id$theother_id" : "$theother_id$consulting_user_id";
        $chat_room_id = (int)$chat_room;

        if ($chat_exist = ChatRoom::where('room_id', $chat_room_id)->first()) {
            $room_id = $chat_exist->id;
            $chat_exist->update(['consult_id'=>$consult_id]);
        } else {
            $room = new ChatRoom();
            $room->create([
                'room_id' => $chat_room_id,
                'consult_id' => $consult_id,
                'user_id_one' => $consulting_user_id,
                'user_id_another' => $theother_id
            ]);
            $room_id = ChatRoom::where('room_id', $chat_room_id)->pluck('id')->first();
        }
        //Chatモデルへ反映させる
        Chat::create([
            'room_id' => $room_id,
            'message' => $request->first_chat,
            'from_user' => $consulting_user_id
        ]);

        return redirect()->route('chat.list');
    }

    public function getMyServiceList(){
        $user_id = Auth::id();
        $items = Service::where('user_id', $user_id)->get();

        foreach($items as $item){
            $item->content =
            Str::limit($item->content, 60);
        }

        return view('service.list',compact('items'));
    }

    public function getMyServiceEdit($service_id){
        $item = Service::where('id', $service_id)->first();

        if ($item->public_sign == true) {
            $item->public = "公開中";
        } else {
            $item->public = "非公開中";
        }

        $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

        foreach ($item->categories as $value) {
            $data = ServiceCategory::where('id', $value->id)->first();
            $value->category_name = $data->name;
        }

        $item->area_ids = Area::whereIn('id', $item->area_id)->get();
        foreach ($item->area_ids as $area_id) {
            $area = Area::where('id', $area_id->id)->first();
            $area_id->name = $area->name;
        }

        $categories = ServiceCategory::get();
        $areas = Area::get();

        return view('service.edit',compact('item', 'categories', 'areas'));
    }

    public function updateMyService(Request $request){
        if ($request->public_sign == 1) {
            $public = true;
        } else {
            $public = false;
        }

        $param = [
            'main_title' => $request->main_title,
            'content' => $request->content,
            'category_ids' => $request->category_id,
            'area_id'=> $request->area_id,
            'attention' => $request->attention,
            'public_sign' =>$public,
            'price' => $request->price
        ];

        $service = Service::where('id', $request->service_id)->first();

        $service->update($param);

        return redirect()->route('service.detail',['service_id'=>$request->service_id]);
    }
}
