<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Plan;
use App\Models\HotaruRequest;
use App\Models\UserProfile;
use App\Models\Apply;
use App\Models\OhakamairiSummary;
use App\Models\SanpaiSummary;
use Illuminate\Support\Arr;

class HotaruRequestController extends Controller
{
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
            $request->session()->put('params', $request->all());

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
            }
            return redirect()->route('omamori.confirm');
        }elseif($plan_id == 3){
            $request->session()->put('params', $request->all());

            return redirect()->route('sanpai.confirm');
        }elseif($plan_id == 4){
            $request->session()->put('params', $request->all());

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

        $items = OhakamairiSummary::whereIn('id', $params->ohakamairi_sum_id)->get();

        $sum = 10000000;
        foreach($items as $item){
            $item->ohakamairi_sum_name = $item->name;
            $sum += $item->number;
        }

        return view('request.confirm_ohakamairi', compact('params','items','sum'));
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

        $items = SanpaiSummary::whereIn('id', $params->sanpai_sum_id)->get();

        $sum = 10000000;
        foreach ($items as $item) {
            $item->sanpai_sum_name = $item->name;
            $sum += $item->number;
        }

        return view('request.confirm_sanpai', compact('params','items', 'sum'));
    }

    public function othersConfirm()
    {
        $data = session()->get('params');
        //配列をオブジェクトに変換
        $params = (object)$data;
        $area = Area::where('id', $params->area_id)->first();
        $params->area_name = $area->name;

        return view('request.confirm_others', compact('params'));
    }

    public function done(Request $request)
    {
    $hotaru_request = new HotaruRequest();

    $hotaru_request->create([
        'request_user_id' => $request->user_id,                'plan_id' => $request->plan_id,
        'date_begin' => $request->date_begin,
        'date_end' => $request->date_end,
        'price' => $request->price,
        'area_id' => $request->area_id,
        'address' => $request->address,
        'ohakamairi_sum' => $request->ohakamairi_sum,
        'sanpai_sum' => $request->sanpai_sum,
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
        if($search_contents == null){
            $items = HotaruRequest::get();
        }else{
            $search_contents = (object)$search_contents;
            //エリア検索ランについて
            if($search_contents->area_id == null){
                $search_areas = HotaruRequest::get();
            }else{
                $search_areas = HotaruRequest::get()->whereIn('area_id', $search_contents->area_id);
            };
            //プランについて
            if($search_contents->plan_id == null){
                $search_plans = HotaruRequest::get();
            }else{
                $search_plans = HotaruRequest::get()->whereIn('plan_id', $search_contents->plan_id);
            };
            //報酬金額について
            if($search_contents->price_min  == null){
                if($search_contents->price_max == null){
                    $search_prices = HotaruRequest::get();
                }else{
                    $search_prices = HotaruRequest::where('price', '<=', $search_contents->price_max)->get();
                }
            }else{
                if($search_contents->price_max == null){
                    $search_prices = HotaruRequest::where('price', '>=', $search_contents->price_min)->get();
                }else{
                    $search_prices = HotaruRequest::whereBetween('price', [$search_contents->price_min, $search_contents->price_max])->get();
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
        $user_id = Auth::id();

        //応募済みかの判定
        $applied = Apply::where('request_id', $request_id)
        ->where('apply_user_id', $user_id)
        ->exists();

        $apply_flag = $applied ? 0 : 1;
        //$apply = Arr::has($apply_user_ids, $user_id);

        return view('search.detail',compact('item', 'user_id','d','s', 'apply_flag'));
    }

    public function searchApply(Request $request){
        $apply = new Apply();

        $apply->create([
            'request_id' => $request->request_id,
            'apply_user_id' => Auth::id(),
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
