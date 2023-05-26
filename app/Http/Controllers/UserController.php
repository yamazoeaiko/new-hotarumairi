<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Gender;
use App\Models\Area;
use App\Models\Plan;
use App\Models\OhakamairiSummary;
use App\Models\SanpaiSummary;
use App\Models\HotaruRequest;
use App\Models\Apply;
use App\Models\Confirm;
use App\Models\Payment;
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class UserController extends Controller
{
    public function getMypage()
    {

        return view('mypage.index');
    }

    public function getMyProfile()
    {
        $user_id = Auth::id();
        $item = User::where('id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        if($item->gender == 1) {
            $item->gender_name = "男性";
        }elseif($item->gender == 2) {
            $item->gender_name = "女性";
        }else{
            $item->gender_name = "未設定";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('mypage.myprofile.index', compact('item'));
    }


    public function getUserProfile($user_id)
    {
        $item = User::where('id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        if ($item->gender == 1) {
            $item->gender_name = "男性";
        } elseif ($item->gender == 2) {
            $item->gender_name = "女性";
        } else {
            $item->gender_name = "未設定";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('public_request.entried_detail', compact('item'));
    }

    public function editMyProfile()
    {
        $user_id = Auth::id();
        $item = User::where('id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        if ($item->gender == 1) {
            $item->gender_name = "男性";
        } elseif ($item->gender == 2) {
            $item->gender_name = "女性";
        } else {
            $item->gender_name = "未設定";
        }
        $areas = Area::get();

        return view('mypage.myprofile.edit', compact('item', 'areas'));
    }

    public function updateMyProfile(Request $request)
    {
        $user_id = Auth::id();
        $item = User::where('id', $user_id)->first();
        
        //if($request->twitter_url){
            //$twitter = 'https://twitter.com/'.$request->twitter_url;
            //$item->twitter_url = $twitter;
            //$item->save();
        //}
        //if($request->instagram_url){
            //$instagram = 'https://www.instagram.com/'.$request->instagram_url;
            //$item->instagram_url = $instagram;
            //$item->save();
        //}
        //if($request->others_sns_url){
            //$others = 'https://'.$request->others_sns_url;
            //$item->others_sns_url = $others;
            //$item->save();
        //}
        $param = [
            'nickname' => $request->nickname,
            'trade_name' => $request->trade_name,
            'birthday' => $request->birthday,
            'gender'   => $request->gender,
            'living_area' => $request->living_area,
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $dir = 'profile';
            $file_name = $request->file('image')->getClientOriginalName();
            $param['img_url'] = 'storage/' . $dir . '/' . $file_name;

            $request->file('image')->storeAs('public/' . $dir, $file_name);
        }

        $item->update($param);
        $item->age = Carbon::parse($item->birthday)->age;
        if ($item->gender == 1) {
            $item->gender_name = "男性";
        } elseif ($item->gender == 2) {
            $item->gender_name = "女性";
        } else {
            $item->gender_name = "未設定";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return redirect()->route('myprofile.index', compact('item'));
    }
}
