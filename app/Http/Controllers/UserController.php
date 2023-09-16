<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\Payment;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Favorite;
use App\Models\Service;
use App\Models\Follow;
use App\Models\ServiceCategory;
use App\Models\Identification;
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

        $identification = Identification::where('user_id', $user_id)
        ->orderBy('created_at', 'desc')
        ->first();
        if($identification){
            if($identification->identification_agreement == 'pending'){
                $item->identification_agreement = 'pending';
            }elseif($identification->identification_agreement == 'approved') {
                $item->identification_agreement = 'approved';
            } elseif ($identification->identification_agreement == 'unapproved') {
                $item->identification_agreement = 'unapproved';
            }
        }else {
            $item->identification_agreement = 'unsubmit';
        }


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
            $file = $request->file('image');
            $file_name = $request->file('image')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

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

    public function favoriteFollow(){
        $user_id = Auth::id();

        $favorites = Favorite::orderBy('created_at', 'desc')
        ->where('user_id', $user_id)
        ->get();
        foreach($favorites as $favorite){
            $item = Service::where('id', $favorite->favorite_id)->first();

            if ($item->category_ids) {
                $favorite->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

                foreach ($favorite->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $provider = User::where('id', $item->offer_user_id)->first();

            $favorite->profile_image = $provider->img_url;
            $favorite->provider_name = $provider->nickname;

            $favorite->photo_1 = $item->photo_1;
            $favorite->price = $item->price;
        }

        $follows = Follow::orderBy('created_at', 'desc')
        ->where('user_id', $user_id)
        ->get();

        foreach($follows as $follow){
            $user = User::where('id', $follow->follow_id)->first();

            $follow->img_url = $user->img_url;
            $follow->user_name = $user->nickname;

            $services = Service::where('offer_user_id', $user->id)->get();
            $follow->count_services = $services->count();
        }


        return view('mypage.favorite_follow.list', compact('favorites', 'follows'));
    }

    public function getUserDetail($user_id){
        $auth_id = Auth::id();
        $item = User::where('id', $user_id)->first();
        $item->follow = Follow::where('follow_id', $item->id)->where('user_id', $auth_id)->exists();

        if($item->gender == 1){
            $item->gender_name = '男性';
        }elseif($item->gender == 2){
            $item->gender_name = '女性';
        }else{
            $item->gender_name = '未設定';
        }

        $item->age = Carbon::parse($item->birthday)->age;

        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('user.detail', compact('item'));
    }

    public function sendIdentificationPhoto(Request $request){
        $user = User::where('id', $request->user_id)->first();
        $identification = new Identification();

        if ($request->hasFile('identification_photo')) {
            $dir = 'user_identification_photo';
            $file = $request->file('identification_photo');
            $file_name = $request->file('identification_photo')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }
            
            $identification->identification_photo = 'storage/' . $dir . '/' . $file_name;

            $request->file('identification_photo')->storeAs('public/' . $dir, $file_name);
            $identification->identification_agreement = "pending";
            $identification->user_id = $user->id;
        }
        //2枚目
        if ($request->hasFile('identification_photo_2')) {
            $dir = 'user_identification_photo';
            $file = $request->file('identification_photo_2');
            $file_name = $request->file('identification_photo_2')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $identification->identification_photo_2 = 'storage/' . $dir . '/' . $file_name;

            $request->file('identification_photo_2')->storeAs('public/' . $dir, $file_name);
        }
        $identification->save();
        return redirect()->back();
    }
}
