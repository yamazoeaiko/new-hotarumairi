<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\HotaruRequest;

class HotaruRequestController extends Controller
{
    public function getRequest(){
        
        return view('request.index');
    }

    public function getOhakamairi(){
        $user_id= Auth::id();
        $areas = Area::get();

        return view('request.ohakamairi',compact('user_id', 'areas'));
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

        return view('request.sanpai', compact('user_id', 'areas'));
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

        return view('request.confirm_ohakamairi', compact('params'));
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

        return view('request.confirm_sanpai', compact('params'));
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
        $params = [
            'request_user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'date_begin' => $request->date_begin,
            'date_end' => $request->date_end,
            'price' => $request->price,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'spot' => $request->spot,
            'offering' => $request->offering,
            'cleaning' => $request->cleaning,
            'amulet' => $request->amulet,
            'praying' => $request->praying,
            'goshuin' => $request->goshuin,
            'free' => $request->free,
            'status_id' => '1',
        ];
        HotaruRequest::insert($params);

        return redirect()->route('request.index');
    }

    ////ここから仕事を探す関連//////////////////
    ////////////////////////////////////////
    public function getSearch(){
        //
    }


    /////ここからチャット関連////////////////////////
    /////////////////////////////////////////////
    public function getChat(){
        //
    }
}
