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
        $request->session()->put('params', $request->all());

        if($plan_id == 1){
            return redirect()->route('ohakamairi.confirm');
        }elseif($plan_id == 2){
            return redirect()->route('omamori.confirm');
        }elseif($plan_id == 3){
            return redirect()->route('sanpai.confirm');
        }elseif($plan_id == 4){
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

        return view('request.confirm_omamori', compact('params'));
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
        if($request->file('img_url') !== null){
            //画像処理
            $dir = 'omamori';

            $file_name = $request->file('img_url')->getClientOriginalName();

            // 取得したファイル名で保存
            $img_url = $request->file('img_url')->storeAs('omamori/' . $dir, $file_name);

            $hotaru_request = new HotaruRequest();

            $hotaru_request->create([
                'request_user_id' => $request->user_id,
                'plan_id' => $request->plan_id,
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
                'img_url' => $img_url,
                'praying' => $request->praying,
                'goshuin' => $request->goshuin,
                'goshuin_content' => $request->goshuin_content,
                'free' => $request->free,
                'status_id' => '1',
            ]);
        }else{
            $hotaru_request = new HotaruRequest();

            $hotaru_request->create([
                'request_user_id' => $request->user_id,
                'plan_id' => $request->plan_id,
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
                'praying' => $request->praying,
                'goshuin' => $request->goshuin,
                'goshuin_content' => $request->goshuin_content,
                'free' => $request->free,
                'status_id' => '1',
            ]);
        }

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
            if($search_contents->price == null){
                $search_prices = HotaruRequest::get();
            }else{
                $search_prices = HotaruRequest::get()->where('price','>=', $search_contents->price);
            };
            //検索結果
            $items = $search_areas->intersect($search_plans)->intersect($search_prices);
        }

        foreach($items as $item){
            $plan = Plan::where('id', $item->plan_id)->first();
            $item->plan_name = $plan->name;

            $area = Area::where('id', $item->area_id)->first();
            $item->area_name = $area->name;

            $user = UserProfile::where('user_id', $item->request_user_id)->first();
            $item->profile_img = $user->img_url;
            $item->user_name = $user->nickname;
        }

        $areas = Area::get();
        $plans = Plan::get();

        return view('search.index',compact('items', 'areas', 'plans'));
    }

    public function moreSearch($request_id){
        $item = HotaruRequest::where('id', $request_id)->first();
        $request_user = UserProfile::where('user_id', $item->request_user_id)->first();
        $item->user_name = $request_user->nickname;

        if($item->goshuin == 0){
            $item->goshuin = '御朱印不要';
        }elseif($item->goshuin == 1){
            $item->goshuin = '御朱印希望';
        }

        //$item->ohakamairi_sum
        $data = (string)$item->ohakamairi_sum;
        $d_1 = substr($data, 7, 1);//１項目
        $d_2 = substr($data, 6, 1);//2項目
        $d_3 = substr($data, 5, 1);//３項目
        $d_4 = substr($data, 4, 1);//４項目
        $d_5 = substr($data, 3, 1);//５項目
        $d_6 = substr($data, 2, 1);//６項目

        if($d_1 == 1){
            $d1 = OhakamairiSummary::where('id', 1)->value('name');
        }else{
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
        $user_id = Auth::id();

        //応募済みかの判定
        $applied = Apply::where('id', $request_id)
        ->where('apply_user_id', $user_id)
        ->exists();

        $apply_flag = $applied ? 0 : 1;
        //$apply = Arr::has($apply_user_ids, $user_id);

        return view('search.detail',compact('item', 'user_id','d1','d2','d3','d4','d5','d6','s1','s2','s3','s4', 'apply_flag'));
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
        $price = $request->price;
        $request->session()->put(
            'search_contents',
            [
                'area_id' => $area_id,
                'plan_id' => $plan_id,
                'price' => $price
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
