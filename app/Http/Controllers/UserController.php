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
            $item->gender_name = "その他";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('mypage.myprofile.index', compact('item'));
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
            $item->gender_name = "その他";
        }
        $areas = Area::get();

        return view('mypage.myprofile.edit', compact('item', 'areas'));
    }

    public function updateMyProfile(Request $request)
    {
        $user_id = Auth::id();
        $item = User::where('id', $user_id)->first();
        $param = [
            'nickname' => $request->nickname,
            'birthday' => $request->birthday,
            'gender'   => $request->gender,
            'living_area' => $request->living_area,
            'message' => $request->message
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
            $item->gender_name = "その他";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return redirect()->route('myprofile.index', compact('item'));
    }
}
