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

        $item->goshuin = $item->goshuin == 0 ? '御朱印不要' : '御朱印希望';

        $ohakamairiSum = str_pad((string)$item->ohakamairi_sum, 8, '0', STR_PAD_LEFT);
        $d = [];
        for ($i = 1; $i <= 6; $i++) {
            if (substr($ohakamairiSum, 7 - $i, 1) == 1) {
                $d[$i] = OhakamairiSummary::where('id', $i)->value('name');
            } else {
                $d[$i] = null;
            }
        }

        $sanpaiSum = str_pad((string)$item->sanpai_sum, 8, '0', STR_PAD_LEFT);
        $s = [];
        for ($i = 1; $i <= 4; $i++) {
            if (substr($sanpaiSum, 7 - $i, 1) == 1) {
                $s[$i] = SanpaiSummary::where('id', $i)->value('name');
            } else {
                $s[$i] = null;
            }
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;
        $apply = Apply::where('request_id', $item->id)->get();
        $item->apply_count = $apply->count();


        return view('mypage.myrequest.detail', compact('item', 'user_id', 'd','s'));
    }

    public function editMyRequest($request_id){
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        $item->goshuin = $item->goshuin == 0 ? '御朱印不要' : '御朱印希望';

        $ohakamairiSum = str_pad((string)$item->ohakamairi_sum, 8, '0', STR_PAD_LEFT);
        $d = [];
        for ($i = 1; $i <= 6; $i++) {
            if (substr($ohakamairiSum, 7 - $i, 1) == 1) {
                $d[$i] = OhakamairiSummary::where('id', $i)->value('name');
            } else {
                $d[$i] = null;
            }
        }

        $sanpaiSum = str_pad((string)$item->sanpai_sum, 8, '0', STR_PAD_LEFT);
        $s = [];
        for ($i = 1; $i <= 4; $i++) {
            if (substr($sanpaiSum, 7 - $i, 1) == 1) {
                $s[$i] = SanpaiSummary::where('id', $i)->value('name');
            } else {
                $s[$i] = null;
            }
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;

        $areas = Area::get();

        return view('mypage.myrequest.edit', compact('item', 'user_id', 'd','s', 'areas'));
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
