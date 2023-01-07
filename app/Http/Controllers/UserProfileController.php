<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\Gender;
use App\Models\Area;
use Illuminate\Support\Carbon;

class UserProfileController extends Controller
{
    public function getMypage(){
        
        return view('mypage.index');
    }

    public function getMyProfile(){
        $user_id = Auth::id();
        $item = UserProfile::where('user_id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        $item->gender = Gender::where('id', $item->gender)->value('name');
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('mypage.myprofile', compact('item'));
    }

    public function editMyProfile(){
        $user_id = Auth::id();
        $item = UserProfile::where('user_id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        $item->sex = Gender::where('id', $item->sex)->value('name');
        $areas = Area::get();

        return view('mypage.myprofile_edit', compact('item', 'areas'));
    }

    public function getMyRequest(){

        return view('mypage.myrequest');
    }

    public function getMyApply(){

        return view('mypage.myapply');
    }

    public function updateMyProfile(Request $request){
        $user_id = Auth::id();

        $param = [
            'nickname' => $request->nickname,
            'birthday' => $request->birthday,
            'gender'   => $request->gender,
            'living_area' => $request->living_area,
            'message' => $request->message
        ];

        $item = UserProfile::where('user_id', $user_id)->first();
        $item->update($param);

        $item->age = Carbon::parse($item->birthday)->age;
        $item->gender = Gender::where('id', $item->gender)->value('name');
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return redirect()->route('myprofile.index', compact('item'));
    }
}
