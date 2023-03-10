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
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

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

    public function updateMyProfile(Request $request)
    {
        $user_id = Auth::id();
        $item = UserProfile::where('user_id', $user_id)->first();
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
        $item->gender = Gender::where('id', $item->gender)->value('name');
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return redirect()->route('myprofile.index', compact('item'));
    }

    //?????????????????????????????????
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

        $item->goshuin = $item->goshuin == 0 ? '???????????????' : '???????????????';

        $ohakamairi_summaries = null;
        if ($item->ohakamairi_sum) {
            $ohakamairi_summaries = OhakamairiSummary::whereIn('id', $item->ohakamairi_sum)->get();
        }

        $sanpai_summaries = null;
        if($item->sanpai_sum){
            $sanpai_summaries = SanpaiSummary::whereIn('id', $item->sanpai_sum)->get();
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;
        $applies = Apply::where('request_id', $item->id)->get();
        $item->apply_count = $applies->count();
        
        if($applies !==null){
            $confirm_count = false;
            foreach ($applies as $apply) {
                if (Confirm::where('apply_id', $apply->id)->exists()) {
                    $confirm_count = true;
                    break;
                }
            }
            $item->confirm_count = $confirm_count;

        }
        //????????????????????????????????????????????????


        return view('mypage.myrequest.detail', compact('item', 'user_id', 'ohakamairi_summaries','sanpai_summaries'));
    }

    public function editOhakamairi($request_id){
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;

        $areas = Area::get();
        $summaries = OhakamairiSummary::get();

        return view('mypage.myrequest.edit.edit_ohakamairi', compact('item', 'user_id', 'areas','summaries'));
    }

    public function editOmamori($request_id)
    {
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');


        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;

        $areas = Area::get();
        $summaries = OhakamairiSummary::get();

        return view('mypage.myrequest.edit.edit_omamori', compact('item', 'user_id', 'areas'));
    }

    public function editSanpai($request_id)
    {
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;

        $areas = Area::get();
        $summaries = SanpaiSummary::get();

        return view('mypage.myrequest.edit.edit_sanpai', compact('item', 'user_id', 'areas', 'summaries'));
    }

    public function editOthers($request_id)
    {
        $user_id = Auth::id();
        $item = HotaruRequest::where('id', $request_id)->first();

        $item->user_name = UserProfile::where('user_id', $user_id)->first()->value('nickname');

        $item->goshuin = $item->goshuin == 0 ? '???????????????' : '???????????????';

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
        $summaries = OhakamairiSummary::get();

        return view('mypage.myrequest.edit.edit_others', compact('item', 'user_id', 'd', 's', 'areas', 'summaries'));
    }

    //???????????????
    public function destroyMyrequest($request_id){
        $item = HotaruRequest::where('id', $request_id)->first();
        $item->delete();

        return redirect()->route('mypage.myrequest.index');
    }

    //???????????????????????????????????????
    public function getMyApply(){
        $user_id = Auth::id();
        $items = Apply::where('apply_user_id', $user_id)->get();
        foreach($items as $item){
            $request = HotaruRequest::where('id', $item->request_id)->first();

            $item->id = $request->id;
            $item->price_net = $request->price_net;

            $plan = Plan::where('id',$request->plan_id)->first();
            $item->plan_name = $plan->name;

            $host = UserProfile::where('user_id', $request->request_user_id)->first();
            $item->host_name = $host->nickname;

            $item->date_end = $request->date_end;
            $item->date_begin = $request->date_begin;

            $item->profile_img = $host->img_url;
            $item->user_name = $host->nickname;

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

            $item->status_id = HotaruRequest::where('id', $request_id)->pluck('status_id')->first();

            $item->approved_sign = Confirm::where('apply_id', $item->id)->exists();
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

        $my_id = Auth::id();
        $chat_room =
        $my_id < $user_id ? "$my_id$user_id" : "$user_id$my_id";
        $chat_room_id = (int)$chat_room;
        
        $room = ChatRoom::where('room_id', $chat_room_id)->first();
        
        //stripe??????
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();
        $plan = Plan::where('id', $hotaru_request->plan_id)->first();
        $plan_name = $plan->name;
        $publicKey = config('payment.stripe_public_key');
        // 1. Stripe???????????????????????????????????????????????????
        \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));

        $secretKey = new \Stripe\StripeClient(\Config::get('payment.stripe_secret_key'));
        //??????????????????????????????????????????PaymentIntent?????????
        //$payment_info = $secretKey->paymentIntents->create(
        //  ['amount' => $hotaru_request->total, 'currency' => 'jpy', 'payment_method_types' => ['card']]
        //);

        //??????????????????????????????????????????????????????Stripe API???????????????
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $hotaru_request->price,
                    'product_data' => [
                        'name' => $plan_name,
                    ],
                ],
                'quantity' => '1',
            ]],
            'mode' => 'payment',

            'success_url'          =>  route('mypage.myrequest.paid', ['request_id' => $hotaru_request->id, 'user_id' => $user_id, 'apply_id' => $apply_id]),
            'cancel_url'           => route('mypage.myrequest.member_list', ['request_id' => $hotaru_request->id])
        ]);
        $hotaru_request->update([
            'session_id' => $session->id,
            'status_id' => 3,
        ]);

                //??????????????????????????????
        if($hotaru_request->payment_intent == null){
            $paid_sign = false;
        }else{
            $paid_sign = true;
        }

        return view('mypage.myrequest.member_detail', compact('item', 'request_id', 'apply_id','exist', 'session', 'publicKey', 'hotaru_request', 'paid_sign', 'plan_name','user_id', 'room'));
    }

    //???????????????
    public function paid($request_id, $apply_id, $user_id){
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();
        //Stripe???PaymentIntent???????????????????????????DB?????????
        //require 'vendor/autoload.php';
        $stripe = new \Stripe\StripeClient(\Config::get('payment.stripe_secret_key'));

        $id = $hotaru_request->session_id;
        $session = $stripe->checkout->sessions->retrieve($id);

        $hotaru_request->update([
        'payment_intent' => $session->payment_intent,
        'status_id' => '3'
        ]);

        $confirm = Confirm::where('id', $apply_id)->first();

        $payment = new Payment();
        $payment->create([
            'confirm_id' => $confirm->id
        ]);

        return redirect()->route('mypage.myrequest.member_detail', compact('request_id', 'apply_id', 'user_id'));
    }

    public function getApplyApproval($apply_id, $request_id, $user_id){
        $confirm = new Confirm();
        $confirm->create([
            'apply_id'=> $apply_id,
        ]);
        $apply = Apply::find($apply_id);
        $apply->status = 'accepted';
        $apply->save();

        // Eloquent??????????????????SELECT??????????????????
        $hotaru_request = DB::table('hotaru_requests')
        ->where('id', $request_id)
        ->update(['status_id' => '2']);


        return redirect()->route('mypage.myrequest.member_detail', compact('request_id', 'apply_id', 'user_id'));
    }

    public function getApplyReject($apply_id, $request_id, $user_id){
        $delete_apply = Apply::where('id', $apply_id)->first();
        $delete_apply->delete();

        return redirect()->route('mypage.myrequest.index');
    }

    //myrequest?????????????????????POST
    public function updateOhakamairi($request_id, Request $request){
        
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();


        $param = [
            'date_begin' => $request->date_begin,
            'date_end' => $request->date_end,
            'price' => $request->price,
            'price_net' => $request->price * 0.85,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'ohakamairi_sum' => $request->ohakamairi_sum_id,
            'offering' => $request->offering,
            'cleaning' => $request->cleaning,
            'img_url' => $request->img_url,
            'free' => $request->free,
        ];

        if ($request->hasFile('img_url')) {
            $dir = 'ohakamairi';
            $file_name = $request->file('img_url')->getClientOriginalName();
            $param['img_url'] = 'storage/' . $dir . '/' . $file_name;

            $request->file('img_url')->storeAs('public/' . $dir, $file_name);
        } else {
            $param['img_url'] = $hotaru_request->img_url;
        }

        $hotaru_request->update($param);

        return redirect()->route('mypage.myrequest.detail',['request_id'=>$request_id]);

    }

    public function updateOmamori($request_id, Request $request){
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();

        $param =[
            'date_begin' => $request->date_begin,
            'date_end' => $request->date_end,
            'price' => $request->price,
            'price_net' => $request->price * 0.85,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'amulet' => $request->amulet,
            'img_url' => $request->img_url,
            'free' => $request->free,
        ];

        if ($request->hasFile('img_url')) {
            $dir = 'omamori';
            $file_name = $request->file('img_url')->getClientOriginalName();
            $param['img_url'] = 'storage/' . $dir . '/' . $file_name;

            $request->file('img_url')->storeAs('public/' . $dir, $file_name);
        } else {
            $param['img_url'] = $hotaru_request->img_url;
        }

        $hotaru_request->update($param);

        return redirect()->route('mypage.myrequest.detail', ['request_id' => $request_id]);
    }

    public function updateSanpai($request_id, Request $request){
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();

        $param = [
            'date_begin' => $request->date_begin,
            'date_end' => $request->date_end,
            'price' => $request->price,
            'price_net' => $request->price * 0.85,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'sanpai_sum' => $request->sanpai_sum_id,
            'praying' => $request->praying,
            'amulet' => $request->amulet,
            'goshuin' => $request->goshuin,
            'goshuin_content' => $request->goshuin_content,
            'img_url' => $request->img_url,
            'free' => $request->free,
        ];

        if ($request->hasFile('img_url')) {
            $dir = 'sanpai';
            $file_name = $request->file('img_url')->getClientOriginalName();
            $param['img_url'] = 'storage/' . $dir . '/' . $file_name;

            $request->file('img_url')->storeAs('public/' . $dir, $file_name);
        } else {
            $param['img_url'] = $hotaru_request->img_url;
        }

        $hotaru_request->update($param);

        return redirect()->route('mypage.myrequest.detail', ['request_id' => $request_id]);

    }

    public function updateOthers($request_id, Request $request){
        $hotaru_request = HotaruRequest::where('id', $request_id)->first();

        $param = [
            'free' => $request->free,
            'date_begin' => $request->date_begin,
            'date_end' => $request->date_end,
            'price' => $request->price,
            'price_net' => $request->price * 0.85,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'spot' => $request->spot,
            'img_url' => $request->img_url,
        ];

        if ($request->hasFile('img_url')) {
            $dir = 'others';
            $file_name = $request->file('img_url')->getClientOriginalName();
            $param['img_url'] = 'storage/' . $dir . '/' . $file_name;

            $request->file('img_url')->storeAs('public/' . $dir, $file_name);
        } else {
            $param['img_url'] = $hotaru_request->img_url;
        }

        $hotaru_request->update($param);

        return redirect()->route('mypage.myrequest.detail', ['request_id' => $request_id]);
    }
}
