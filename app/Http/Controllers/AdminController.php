<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Agreement;
use App\Models\Payment;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->type !== 'admin'){
            return redirect()->route('toppage');
        }

        return view('admin.index');
    }

    public function userList(){
        $items = User::where('type', 'user')
        ->orderBy('id', 'desc')->get();

        return view('admin.user.list', compact('items'));
    }

    public function userDetail($user_id){
        $item = User::where('id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        if ($item->gender == 1) {
            $item->gender_name = "男性";
        } elseif ($item->gender == 2) {
            $item->gender_name = "女性";
        } else {
            $item->gender_name = "未設定";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return view('admin.user.detail', compact('item'));
    }

    public function userEdit($user_id){
        $item = User::where('id', $user_id)->first();

        $item->age = Carbon::parse($item->birthday)->age;
        if ($item->gender == 1) {
            $item->gender_name = "男性";
        } elseif ($item->gender == 2) {
            $item->gender_name = "女性";
        } else {
            $item->gender_name = "未設定";
        }

        $areas = Area::get();

        return view('admin.user.edit', compact('item', 'areas'));
    }

    public function userUpdate(Request $request){
        $user_id = $request->user_id;
        $item = User::where('id', $user_id)->first();

        $param = [
            'nickname' => $request->nickname,
            'name' => $request->name,
            'email' => $request->email,
            'trade_name' => $request->trade_name,
            'birthday' => $request->birthday,
            'gender'   => $request->gender,
            'living_area' => $request->living_area,
            'message' => $request->message,
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
            $item->gender_name = "未設定";
        }
        $item->living_area = Area::where('id', $item->living_area)->value('name');

        return redirect()->route('admin.user.detail',['user_id'=>$request->user_id]);
    }

    public function serviceList(){
        $items = Service::orderBy('created_at', 'desc')
            ->where('type', 'service')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($items as $item) {
            if ($item->category_ids) {
                $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

                foreach ($item->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $provider = User::where('id', $item->offer_user_id)->first();

            $item->profile_image = $provider->img_url;
            $item->provider_name = $provider->nickname;
        }
        $categories = ServiceCategory::get();
        $areas = Area::get();


        return view(
            'admin.service.list',
            compact('items', 'categories', 'areas')
        );
    }

    public function serviceDetail($service_id){
        $item = Service::where('id', $service_id)->first();

        $sell_user = User::where('id', $item->offer_user_id)->first();
        $item->user_name = $sell_user->nickname;
        $item->img_url = $sell_user->img_url;
        $living = Area::where('id', $sell_user->living_area)->first();
        if ($living) {
            $item->living_area = $living->name;
        }
        $item->age =
            Carbon::parse($sell_user->birthday)->age;

        if ($item->status == 'open') {
            $item->status_name = "公開中";
        } elseif ($item->status == 'closed') {
            $item->status_name = "非公開中";
        }

        if ($item->category_ids) {
            $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

            foreach ($item->categories as $value) {
                $data = ServiceCategory::where('id', $value->id)->first();
                $value->category_name = $data->name;
            }
        }

        if ($item->area_id) {
            $item->area_ids = Area::whereIn('id', $item->area_id)->get();
            foreach ($item->area_ids as $area_id) {
                $area = Area::where('id', $area_id->id)->first();
                $area_id->name = $area->name;
            }
        }
        return view('admin.service.detail',compact('item'));
    }

    public function serviceEdit($service_id){
        $item = Service::where('id', $service_id)->first();

        if ($item->status == 'open') {
            $item->status_name = "公開中";
        } elseif ($item->status == 'closed') {
            $item->status_name = "非公開中";
        }

        if ($item->category_ids) {
            $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();
        }

        if ($item->area_id) {
            $item->area_ids = Area::whereIn('id', $item->area_id)->get();
        }

        $categories = ServiceCategory::get();
        $areas = Area::get();

        return view('admin.service.edit', compact('item', 'categories', 'areas'));
    }

    public function serviceUpdate(Request $request)
    {
        if ($request->status == 1) {
            $status = 'open';
        } elseif ($request->status == 2) {
            $status = 'closed';
        }

        $service = Service::where('id', $request->service_id)->first();

        $service->main_title = $request->main_title;
        $service->content = $request->content;
        $service->category_ids = $request->category_ids;
        $service->area_id = $request->area_id;
        $service->attention = $request->attention;
        $service->status = $status;
        $service->price = $request->price;
        $service->delivery_deadline = $request->delivery_deadline;
        $service->application_deadline = $request->application_deadline;
        $service->free = $request->free;

        if ($request->hasFile('photo_1')) {
            $dir = 'service';
            $file_name = $request->file('photo_1')->getClientOriginalName();
            $path_1 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_1')->storeAs('public/' . $dir, $file_name);
            $service->photo_1 = $path_1;
        }
        if ($request->hasFile('photo_2')) {
            $dir = 'service';
            $file_name = $request->file('photo_2')->getClientOriginalName();
            $path_2 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_2')->storeAs('public/' . $dir, $file_name);
            $service->photo_2 = $path_2;
        }
        if ($request->hasFile('photo_3')) {
            $dir = 'service';
            $file_name = $request->file('photo_3')->getClientOriginalName();
            $path_3 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_3')->storeAs('public/' . $dir, $file_name);
            $service->photo_3 = $path_3;
        }
        if ($request->hasFile('photo_4')) {
            $dir = 'service';
            $file_name = $request->file('photo_4')->getClientOriginalName();
            $path_4 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_4')->storeAs('public/' . $dir, $file_name);
            $service->photo_4 = $path_4;
        }
        if ($request->hasFile('photo_5')) {
            $dir = 'service';
            $file_name = $request->file('photo_5')->getClientOriginalName();
            $path_5 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_5')->storeAs('public/' . $dir, $file_name);
            $service->photo_5 = $path_5;
        }
        if ($request->hasFile('photo_6')) {
            $dir = 'service';
            $file_name = $request->file('photo_6')->getClientOriginalName();
            $path_6 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_6')->storeAs('public/' . $dir, $file_name);
            $service->photo_6 = $path_6;
        }
        if ($request->hasFile('photo_7')) {
            $dir = 'service';
            $file_name = $request->file('photo_7')->getClientOriginalName();
            $path_7 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_7')->storeAs('public/' . $dir, $file_name);
            $service->photo_7 = $path_7;
        }
        if ($request->hasFile('photo_8')) {
            $dir = 'service';
            $file_name = $request->file('photo_8')->getClientOriginalName();
            $path_8 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_8')->storeAs('public/' . $dir, $file_name);
            $service->photo_8 = $path_8;
        }
        $service->save();

        return redirect()->route('admin.service.detail', ['service_id' => $request->service_id]);
    }
}
