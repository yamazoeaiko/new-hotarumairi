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

        return view('mypage.myprofile.index', compact('item'));
    }

    public function editMyProfile(){
        $user_id = Auth::id();
        $item = UserProfile::where('user_id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        $item->sex = Gender::where('id', $item->sex)->value('name');
        $areas = Area::get();

        return view('mypage.myprofile.edit', compact('item', 'areas'));
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

    public function updateImage(Request $request){

        $user_id = Auth::id();
        $dir = 'profile';

        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $img_url = $request->file('image')->storeAs('public/' . $dir, $file_name);

        //DBに保存
        $param = [
            'img_url' => 'storage/' . $dir . '/' . $file_name
        ];
        $item = UserProfile::where('user_id', $user_id)->first();
        $item->update($param);

        return redirect()->route('myprofile.index', compact('item'));
    }

    //依頼している案件の確認
    public function getMyRequest(){
        $user_id = Auth::id();
        $items = HotaruRequest::where('request_user_id', $user_id)->get();

        foreach($items as $item){
            $plan = Plan::where('id', $item->plan_id)->first();
            $item->plan_name = $plan->name;
            $apply = Apply::where('request_id', $item->id)->get();
            $item->apply_count = $apply->count();
        }
        
        return view('mypage.myrequest.index',
        compact('items'));
    }

    public function getMyRequestDetail($request_id){
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        if ($item->goshuin == 0) {
            $item->goshuin = '御朱印不要';
        } elseif ($item->goshuin == 1) {
            $item->goshuin = '御朱印希望';
        }

        //$item->ohakamairi_sum
        $data = (string)$item->ohakamairi_sum;
        $d_1 = substr($data, 7, 1); //１項目
        $d_2 = substr($data, 6, 1); //2項目
        $d_3 = substr($data, 5, 1); //３項目
        $d_4 = substr($data, 4, 1); //４項目
        $d_5 = substr($data, 3, 1); //５項目
        $d_6 = substr($data, 2, 1); //６項目

        if ($d_1 == 1) {
            $d1 = OhakamairiSummary::where('id', 1)->value('name');
        } else {
            $d1 = null;
        }
        if ($d_2 == 1) {
            $d2 = OhakamairiSummary::where('id', 2)->value('name');
        } else {
            $d2 = null;
        }
        if ($d_3 == 1) {
            $d3 = OhakamairiSummary::where('id', 3)->value('name');
        } else {
            $d3 = null;
        }
        if ($d_4 == 1) {
            $d4 = OhakamairiSummary::where('id', 4)->value('name');
        } else {
            $d4 = null;
        }
        if ($d_5 == 1) {
            $d5 = OhakamairiSummary::where('id', 5)->value('name');
        } else {
            $d5 = null;
        }
        if ($d_6 == 1) {
            $d6 = OhakamairiSummary::where('id', 6)->value('name');
        } else {
            $d6 = null;
        }

        //$sanpai_sum
        $sanpai_data = (string)$item->sanpai_sum;
        $s_1 = substr($sanpai_data, 7, 1); //１項目
        $s_2 = substr($sanpai_data, 6, 1); //2項目
        $s_3 = substr($sanpai_data, 5, 1); //３項目
        $s_4 = substr($sanpai_data, 4, 1); //４項目

        if ($s_1 == 1) {
            $s1 = SanpaiSummary::where('id', 1)->value('name');
        } else {
            $s1 = null;
        }
        if ($s_2 == 1) {
            $s2 = SanpaiSummary::where('id', 2)->value('name');
        } else {
            $s2 = null;
        }
        if ($s_3 == 1) {
            $s3 = SanpaiSummary::where('id', 3)->value('name');
        } else {
            $s3 = null;
        }
        if ($s_4 == 1) {
            $s4 = SanpaiSummary::where('id', 4)->value('name');
        } else {
            $s4 = null;
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;
        $apply = Apply::where('request_id', $item->id)->get();
        $item->apply_count = $apply->count();


        return view('mypage.myrequest.detail', compact('item', 'user_id', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 's1', 's2', 's3', 's4'));
    }

    public function editMyRequest($request_id){
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        if ($item->goshuin == 0) {
            $item->goshuin = '御朱印不要';
        } elseif ($item->goshuin == 1) {
            $item->goshuin = '御朱印希望';
        }

        //$item->ohakamairi_sum
        $data = (string)$item->ohakamairi_sum;
        $d_1 = substr($data, 7, 1); //１項目
        $d_2 = substr($data, 6, 1); //2項目
        $d_3 = substr($data, 5, 1); //３項目
        $d_4 = substr($data, 4, 1); //４項目
        $d_5 = substr($data, 3, 1); //５項目
        $d_6 = substr($data, 2, 1); //６項目

        if ($d_1 == 1) {
            $d1 = OhakamairiSummary::where('id', 1)->value('name');
        } else {
            $d1 = null;
        }
        if ($d_2 == 1) {
            $d2 = OhakamairiSummary::where('id', 2)->value('name');
        } else {
            $d2 = null;
        }
        if ($d_3 == 1) {
            $d3 = OhakamairiSummary::where('id', 3)->value('name');
        } else {
            $d3 = null;
        }
        if ($d_4 == 1) {
            $d4 = OhakamairiSummary::where('id', 4)->value('name');
        } else {
            $d4 = null;
        }
        if ($d_5 == 1) {
            $d5 = OhakamairiSummary::where('id', 5)->value('name');
        } else {
            $d5 = null;
        }
        if ($d_6 == 1) {
            $d6 = OhakamairiSummary::where('id', 6)->value('name');
        } else {
            $d6 = null;
        }

        //$sanpai_sum
        $sanpai_data = (string)$item->sanpai_sum;
        $s_1 = substr($sanpai_data, 7, 1); //１項目
        $s_2 = substr($sanpai_data, 6, 1); //2項目
        $s_3 = substr($sanpai_data, 5, 1); //３項目
        $s_4 = substr($sanpai_data, 4, 1); //４項目

        if ($s_1 == 1) {
            $s1 = SanpaiSummary::where('id', 1)->value('name');
        } else {
            $s1 = null;
        }
        if ($s_2 == 1) {
            $s2 = SanpaiSummary::where('id', 2)->value('name');
        } else {
            $s2 = null;
        }
        if ($s_3 == 1) {
            $s3 = SanpaiSummary::where('id', 3)->value('name');
        } else {
            $s3 = null;
        }
        if ($s_4 == 1) {
            $s4 = SanpaiSummary::where('id', 4)->value('name');
        } else {
            $s4 = null;
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;

        $areas = Area::get();

        return view('mypage.myrequest.edit', compact('item', 'user_id', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 's1', 's2', 's3', 's4', 'areas'));
    }

    //依頼の削除
    public function destroyMyrequest($request_id){
        $item = HotaruRequest::where('id', $request_id)->first();
        $item->delete();

        return redirect()->route('mypage.myrequest.index');
    }

    //代行を引き受ける案件の確認
    public function getMyApply(){
        $user_id = Auth::id();
        $items = Apply::where('apply_user_id', $user_id)->get();
        foreach($items as $item){
            $request = HotaruRequest::where('id', $item->request_id)->first();

            $item->id = $request->id;

            $plan = Plan::where('id',$request->plan_id)->first();
            $item->plan_name = $plan->name;

            $host = UserProfile::where('user_id', $request->request_user_id)->first();
            $item->host_name = $host->nickname;

            $item->date_end = $request->date_end;
            $item->date_begin = $request->date_begin;

            $item->price = $request->price;
        }
        return view('mypage.myapply.index',
        compact('items'));
    }

    public function getApplyMemberList($request_id){
        $items = Apply::where('request_id', $request_id)->get();
        foreach($items as $item){
            $apply_user = UserProfile::where('user_id', $item->apply_user_id)->first();
            $item->nickname = $apply_user->nickname;
            $item->profile_img = $apply_user->img_url;
        }

        return view('mypage.myrequest.member_list',compact('items'));
    }

    public function getApplyMemberDetail($request_id, $user_id, $apply_id){
        $item = UserProfile::where('user_id', $user_id)->first();
        $gender = Gender::find($item->gender);
        if ($gender) {
            $item->gender = $gender->name;
        };
        
        $item->age = Carbon::parse($item->birthday)->age;

        $area = Area::find($item->living_area);
        if ($area) {
            $item->living_area = $area->name;
        }
        $exist = Confirm::where('apply_id', $apply_id)->exists();

        return view('mypage.myrequest.member_detail', compact('item', 'request_id', 'apply_id','exist'));
    }

    public function getApplyApproval($apply_id, $request_id, $user_id){
        $confirm = new Confirm();
        $confirm->create([
            'apply_id'=> $apply_id,
        ]);
    
        $request = HotaruRequest::where('id', $request_id)->first();
        $param=[
            'status_id'=>'3',
        ];
        $request->update($param);

        return redirect()->route('mypage.myrequest.index');
    }

    public function getApplyReject($apply_id, $request_id, $user_id){
        $delete_apply = Apply::where('id', $apply_id)->first();
        $delete_apply->delete();

        return redirect()->route('mypage.myrequest.index');
    }
}
