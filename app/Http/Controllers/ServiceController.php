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
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class ServiceController extends Controller
{
    public function search(){
        $items = Service::get()->filter(function ($item) {
            return $item->public_sign != false;
        });

        foreach($items as $item){
            $item->categories = ServiceCategory::whereIn('id',$item->category_ids)->get();
            
            foreach($item->categories as $value){
                $data = ServiceCategory::where('id',$value->id)->first();
                $value->category_name = $data->name;
            }

            $user = UserProfile::where('id', $item->user_id)->first();
            $item->user_name = $user->nickname;
            $item->img_url = $user->img_url;

        }

        return view('service.index',
        compact('items'));
    }

    public function showUser($user_id){

    }

    public function showDetail($service_id){
        $item = Service::where('id', $service_id)->first();

        $user = UserProfile::where('id', $item->user_id)->first();
        $item->user_name = $user->nickname;
        $item->img_url = $user->img_url;
        $item->living_area = Area::where('id', $user->area_id)->pluck('name')->first();
        $item->age =
        Carbon::parse($user->birthday)->age;

        if($item->public_sign ==true){
            $item->public = "公開中";
        }else{
            $item->public = "非公開中";
        }

        $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

        foreach ($item->categories as $value) {
            $data = ServiceCategory::where('id', $value->id)->first();
            $value->category_name = $data->name;
        }

        return view('service.detail',
        compact('item'));
    }

    public function create(){
        //
    }

    public function done(Request $request){
        //
    }

    public function edit($service_id){
        //
    }

    public function update(Request $request){
        //
    }

    public function destroy(Request $request){
        //
    }
}
