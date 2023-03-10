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
    public function toppage(){
        $items = Service::orderBy('created_at', 'desc')->get();

        return view('index',compact('items'));
    }
    public function getRequest(){
        
        return view('request.index');
    }

    public function getOhakamairi(){
        $user_id= Auth::id();
        $areas = Area::get();
        $summaries = OhakamairiSummary::get();

        return view('request.ohakamairi',compact('user_id', 'areas', 'summaries'));
    }

    public function getOmamori()
    {
        $user_id = Auth::id();
        $areas = Area::get();

        return view('request.omamori', compact('user_id', 'areas'));
    }

    public function getSanpai()
    {
        $user_id = Auth::id();
        $areas = Area::get();
        $summaries = SanpaiSummary::get();

        return view('request.sanpai', compact('user_id', 'areas', 'summaries'));
    }

    public function getOthers()
    {
        $user_id = Auth::id();
        $areas = Area::get();

        return view('request.others', compact('user_id', 'areas'));
    }

    //依頼作成→セッションに保存し確認画面へ//
    public function sessionSave(Request $request)
    {
        $plan_id = $request->plan_id;

        if($plan_id == 1){
            if ($request->hasFile('img_url')) {
                $dir = 'ohakamairi';
                $file_name = $request->file('img_url')->getClientOriginalName();
                // 画像の保存
                $request->file('img_url')->storeAs('public/' . $dir, $file_name);
                // 画像のパスをセッションに保存
                $request->session()->put('path', 'storage/' . $dir . '/' . $file_name);

                $except = $request->except('img_url');
                $request->session()->put('params', $except);
            } else {
            $request->session()->put('params', $request->all());
            }

            return redirect()->route('ohakamairi.confirm');
        }elseif($plan_id == 2){
            if ($request->hasFile('img_url')) {
                $dir = 'omamori';
                $file_name = $request->file('img_url')->getClientOriginalName();
                // 画像の保存
                $request->file('img_url')->storeAs('public/'.$dir,$file_name);
                // 画像のパスをセッションに保存
                $request->session()->put('path', 'storage/'.$dir. '/'. $file_name);

                $except = $request->except('img_url');
                $request->session()->put('params', $except);
            }else{
                $request->session()->put('params', $request->all());
            }
            return redirect()->route('omamori.confirm');
        }elseif($plan_id == 3){
            
            if ($request->hasFile('img_url')) {
                $dir = 'sanpai';
                $file_name = $request->file('img_url')->getClientOriginalName();
                // 画像の保存
                $request->file('img_url')->storeAs('public/' . $dir, $file_name);
                // 画像のパスをセッションに保存
                $request->session()->put('path', 'storage/' . $dir . '/' . $file_name);

                $except = $request->except('img_url');
                $request->session()->put('params', $except);
            } else {
            $request->session()->put('params', $request->all());
            }

            return redirect()->route('sanpai.confirm');

        }elseif($plan_id == 4){
            if ($request->hasFile('img_url')) {
                $dir = 'others';
                $file_name = $request->file('img_url')->getClientOriginalName();
                // 画像の保存
                $request->file('img_url')->storeAs('public/' . $dir, $file_name);
                // 画像のパスをセッションに保存
                $request->session()->put('path', 'storage/' . $dir . '/' . $file_name);

                $except = $request->except('img_url');
                $request->session()->put('params', $except);
            } else {
            $request->session()->put('params', $request->all());
            }

            return redirect()->route('others.confirm');
        }
    }

    //各プランの確認画面//
    public function ohakamairiConfirm()
    {
        $data = session()->get('params');
        //配列をオブジェクトに変換
        $params = (object)$data;
        $area = Area::where('id', $params->area_id)->first();
        $params->area_name = $area->name;
        $path = session('path');
        $fileName = basename($path);

        $ohakamairi_sum_ids = $params->ohakamairi_sum_id;
        $ohakamairi_sum = json_encode($ohakamairi_sum_ids, JSON_UNESCAPED_UNICODE);
        $summaries = OhakamairiSummary::whereIn('id', $ohakamairi_sum_ids)->get();

        return view('request.confirm_ohakamairi', compact('params','summaries','path', 'fileName','ohakamairi_sum_ids', 'ohakamairi_sum'));
    }

    public function omamoriConfirm()
    {
        $data = session()->get('params');
        //配列をオブジェクトに変換
        $params = (object)$data;
        $area = Area::where('id', $params->area_id)->first();
        $params->area_name = $area->name;
        $path = session('path');
        $fileName = basename($path);

        return view('request.confirm_omamori', compact('params', 'path', 'fileName'));
    }

    public function sanpaiConfirm()
    {
        $data = session()->get('params');
        //配列をオブジェクトに変換
        $params = (object)$data;
        $area = Area::where('id', $params->area_id)->first();
        $params->area_name = $area->name;

        $path = session('path');
        $fileName = basename($path);

        $sanpai_sum_ids = $params->sanpai_sum_id;
        $sanpai_sum = json_encode($sanpai_sum_ids, JSON_UNESCAPED_UNICODE);
        $summaries = SanpaiSummary::whereIn('id', $sanpai_sum_ids)->get();

        return view('request.confirm_sanpai', compact('params', 'summaries','path', 'fileName', 'sanpai_sum_ids', 'sanpai_sum'));
    }

    public function othersConfirm()
    {
        $data = session()->get('params');
        //配列をオブジェクトに変換
        $params = (object)$data;
        $area = Area::where('id', $params->area_id)->first();
        $params->area_name = $area->name;
        $path = session('path');
        $fileName = basename($path);

        return view('request.confirm_others', compact('params', 'path', 'fileName'));
    }

    public function done(Request $request)
    {
    $hotaru_request = new HotaruRequest();

    
    $hotaru_request->create([
        'request_user_id' => $request->user_id,                'plan_id' => $request->plan_id,
        'date_begin' => $request->date_begin,
        'date_end' => $request->date_end,
        'price' => $request->price,
        'price_net' => $request->price*0.85,
        'area_id' => $request->area_id,
        'address' => $request->address,
        'ohakamairi_sum' => json_decode($request->ohakamairi_sum),
        'sanpai_sum' => json_decode($request->sanpai_sum),
        'spot' => $request->spot,
        'offering' => $request->offering,
        'cleaning' => $request->cleaning,
        'amulet' => $request->amulet,
        'img_url' => $request->img_url,
        'praying' => $request->praying,
        'goshuin' => $request->goshuin,
        'goshuin_content' => $request->goshuin_content,
        'free' => $request->free,
        'status_id' => '1',
            ]);

        return redirect()->route('request.index');
    }

    ////ここから仕事を探す関連//////////////////
    ////////////////////////////////////////
    public function getSearch(){
        $search_contents = session()->get('search_contents');
        if ($search_contents == null) {
            $items = HotaruRequest::get();
        } else {
            $search_contents = (object)$search_contents;
            //エリア検索ランについて
            if (isset($search_contents->area_id) && is_array($search_contents->area_id) && count($search_contents->area_id) > 0) {
                $search_areas = HotaruRequest::whereIn('area_id', $search_contents->area_id)->get();
            } else {
                $search_areas = HotaruRequest::get();
            }
            //プランについて
            if($search_contents->plan_id == null){
                $search_plans = HotaruRequest::get();
            }else{
                $search_plans = HotaruRequest::get()->whereIn('plan_id', $search_contents->plan_id);
            };
            //報酬金額について
            //price_net＝マージン15％を仮設定
            if($search_contents->price_min  == null){
                if($search_contents->price_max == null){
                    $search_prices = HotaruRequest::get();
                }else{
                    $search_prices = HotaruRequest::where('price_net', '<=', $search_contents->price_max)->get();
                }
            }else{
                if($search_contents->price_max == null){
                    $search_prices = HotaruRequest::where('price_net', '>=', $search_contents->price_min)->get();
                }else{
                    $search_prices = HotaruRequest::whereBetween('price_net', [$search_contents->price_min, $search_contents->price_max])->get();
                }

            }
            //検索結果
            $items = $search_areas->intersect($search_plans)->intersect($search_prices)->sortBy('date_end');
        }
 

        foreach($items as $item){
            $plan = Plan::where('id', $item->plan_id)->first();
            $item->plan_name = $plan->name;

            $area = Area::where('id', $item->area_id)->first();
            $item->area_name = $area->name;

            $user = UserProfile::where('user_id', $item->request_user_id)->first();
            $item->profile_img = $user->img_url;
            $item->user_name = $user->nickname;

            if(Auth::check()){
                $user_id = Auth::id();
                $item->applied = Apply::where('request_id', $item->id)->where('apply_user_id', $user_id)->first();
            }
        }

        $areas = Area::get();
        $plans = Plan::get();

        return view('search.index',compact('items', 'areas', 'plans'));
    }

    public function moreSearch($request_id){
        $item = HotaruRequest::where('id', $request_id)->first();
        $request_user = UserProfile::where('user_id', $item->request_user_id)->first();
        $item->user_name = $request_user->nickname;

        $item->goshuin = $item->goshuin == 0 ? '御朱印不要' : '御朱印希望';

        $ohakamairi_summaries = null;
        if ($item->ohakamairi_sum) {
            $ohakamairi_summaries = OhakamairiSummary::whereIn('id', $item->ohakamairi_sum)->get();
        }

        $sanpai_summaries = null;
        if ($item->sanpai_sum) {
            $sanpai_summaries = SanpaiSummary::whereIn('id', $item->sanpai_sum)->get();
        }

        $area = Area::where('id', $item->area_id)->first();
        $item->area_name = $area->name;
        $user_id = Auth::id();

        //応募済みかの判定
        $applied = Apply::where('request_id', $request_id)
        ->where('apply_user_id', $user_id)
        ->exists();

        $apply_flag = $applied ? 0 : 1;
        //$apply = Arr::has($apply_user_ids, $user_id);

        return view('search.detail',compact('item', 'user_id', 'ohakamairi_summaries', 'sanpai_summaries', 'apply_flag'));
    }

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
