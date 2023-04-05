<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\Entry;
use App\Models\Confirm;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Favorite;
use App\Models\Follow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function providerIndex()
    {
        return view('provider_index');
    }

    public function seekerIndex()
    {
        return view('seeker_index');
    }

    public function toppage()
    {
        $items = Service::orderBy('created_at', 'desc')
            ->whereNull('request_user_id')
            ->get();


        return view('index', compact('items'));
    }
    public function getRequest()
    {

        return view('request.index');
    }

    public function search()
    {
        $user_id = Auth::id();
        $search_contents_service = session()->get('search_contents_service');
        if ($search_contents_service == null) {
            $items = Service::whereNotNull('offer_user_id')
                ->orderBy('application_deadline')
                ->get();
        } else {
            $search_contents_service = (object)$search_contents_service;
            //プランについて
            $search_categories = Service::query();

            if ($search_contents_service->category_ids != null) {
                $category_ids = explode(',', $search_contents_service->category_ids);
                foreach ($category_ids as $category_id) {
                    $search_categories = $search_categories->orWhere('category_ids', 'like', '%' . $category_id . '%');
                }
            }

            $search_categories = $search_categories->get();


            //報酬金額について
            if ($search_contents_service->price_min  == null) {
                if ($search_contents_service->price_max == null) {
                    $search_prices = Service::get();
                } else {
                    $search_prices = Service::where('price', '<=', $search_contents_service->price_max)->get();
                }
            } else {
                if ($search_contents_service->price_max == null) {
                    $search_prices = Service::where('price', '>=', $search_contents_service->price_min)->get();
                } else {
                    $search_prices = Service::whereBetween('price', [$search_contents_service->price_min, $search_contents_service->price_max])->get();
                }
            }
            //検索結果
            $items = $search_categories
                ->intersect($search_prices)
                ->where('offer_user_id', '!=', null)
                ->sortBy('application_deadline');
        }

        foreach ($items as $item) {
            $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

            foreach ($item->categories as $value) {
                $data = ServiceCategory::where('id', $value->id)->first();
                $value->category_name = $data->name;
            }

            $user = User::where('id', $item->offer_user_id)->first();
            $item->user_name = $user->nickname;
            $item->img_url = $user->img_url;

            $item->favorite = Favorite::where('favorite_id', $item->id)->where('user_id', $user_id)->exists();

            $item->follow = Follow::where('follow_id', $item->user_id)->where('user_id', $user_id)->exists();
        }
        $categories = ServiceCategory::get();


        return view(
            'service.seeker.index',
            compact('items', 'categories')
        );
    }

    public function showUser($user_id)
    {
    }

    public function showDetail($service_id)
    {
        $item = Service::where('id', $service_id)->first();

        $user = User::where('id', $item->offer_user_id)->first();
        $item->user_name = $user->nickname;
        $item->img_url = $user->img_url;
        $living = Area::where('id', $user->living_area)->first();
        $item->living_area = $living->name;
        $item->age =
            Carbon::parse($user->birthday)->age;

        if ($item->public_sign == true) {
            $item->public = "公開中";
        } else {
            $item->public = "非公開中";
        }

        if ($item->categories) {
            $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

            foreach ($item->categories as $value) {
                $data = ServiceCategory::where('id', $value->id)->first();
                $value->category_name = $data->name;
            }
        }

        if ($item->area_ids) {
            $item->area_ids = Area::whereIn('id', $item->area_id)->get();
            foreach ($item->area_ids as $area_id) {
                $area = Area::where('id', $area_id->id)->first();
                $area_id->name = $area->name;
            }
        }

        $user_id = Auth::id();

        $item->favorite = Favorite::where('favorite_id', $item->id)->where('user_id', $user_id)->exists();

        $item->follow = Follow::where('follow_id', $item->offer_user_id)->where('user_id', $user_id)->exists();

        return view(
            'service.seeker.detail',
            compact('item', 'user_id')
        );
    }

    public function request()
    {
        $user_id = Auth::id();
        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view(
            'service.seeker.request',
            compact('user_id', 'areas', 'categories')
        );
    }

    public function create()
    {
        $user_id = Auth::id();
        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view(
            'service.provider.create',
            compact('user_id', 'areas', 'categories')
        );
    }

    public function done(Request $request)
    {
        $service = new Service();

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

        if ($request->offer_user_id) {
            $service->offer_usr_id = $request->offer_user_id;
        }
        if ($request->request_user_id) {
            $service->request_user_id = $request->request_user_id;
        }
        $service->main_title = $request->main_title;
        $service->content = $request->content;
        $service->category_ids = $request->category_id;
        $service->attention = $request->attention;
        $service->free = $request->free;
        $service->price = $request->price;
        $service->price_net = ($request->price) * 0.85;
        $service->application_deadline = $request->applying_deadline;
        $service->delivery_deadline = $request->delivery_deadline;
        $service->area_id = $request->area_id;
        $service->public_sign = $request->public_sign;
        $service->save();

        return redirect()->route('mypage.service.list');
    }

    public function edit($service_id)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }

    public function sendConsult(Request $request)
    {
        $consult = new ServiceConsult();
        $consulting_user_id = Auth::id();
        $theother_id = $request->host_user;

        $consult->create([
            'host_user' => $theother_id,
            'service_id' => $request->service_id,
            'consulting_user' => $consulting_user_id,
            'first_chat' => $request->first_chat
        ]);

        $consult_id = ServiceConsult::where('service_id', $request->service_id)->where('consulting_user', $consulting_user_id)->pluck('id')->first();

        $chat_room =
            $consulting_user_id < $theother_id ? "$consulting_user_id$theother_id" : "$theother_id$consulting_user_id";
        $chat_room_id = (int)$chat_room;

        if ($chat_exist = ChatRoom::where('room_id', $chat_room_id)->first()) {
            $room_id = $chat_exist->id;
            $chat_exist->update(['consult_id' => $consult_id]);
        } else {
            $room = new ChatRoom();
            $room->create([
                'room_id' => $chat_room_id,
                'consult_id' => $consult_id,
                'user_id_one' => $consulting_user_id,
                'user_id_another' => $theother_id
            ]);
            $room_id = ChatRoom::where('room_id', $chat_room_id)->pluck('id')->first();
        }
        //Chatモデルへ反映させる
        Chat::create([
            'room_id' => $room_id,
            'message' => $request->first_chat,
            'from_user' => $consulting_user_id
        ]);

        $data = Service::where('id', $request->service_id)->first();

        $fix = new FixedService();
        $fix->service_id = $request->service_id;
        $fix->consult_id = $consult_id;
        $fix->host_user = $theother_id;
        $fix->buy_user = $consulting_user_id;
        $fix->main_title = $data->main_title;
        $fix->price = $data->price;
        $fix->content = $data->content;
        $fix->save();

        return redirect()->route('chat.list');
    }

    public function getMyServiceList()
    {
        $user_id = Auth::id();
        $items = Service::where('offer_user_id', $user_id)->get();

        foreach ($items as $item) {
            $item->content =
                Str::limit($item->content, 60);
        }

        $requests = Service::where('request_user_id', $user_id)->get();
        foreach ($requests as $request) {
            $request->content = Str::limit($request->content, 60);
        }

        if ($consults = ServiceConsult::where('host_user', $user_id)->get()) {
            foreach ($consults as $consult) {
                $consulted_service = Service::where('id', $consult->service_id)->first();
                $consult->service_name = $consulted_service->main_title;

                $consulting_user = User::where('id', $consult->consulting_user)->first();
                $consult->consulting_user_name = $consulting_user->nickname;
                $consult->profile_img = $consulting_user->img_url;
                $consult->consulting_user_id = $consulting_user->id;

                $consult->first_chat = Str::limit($consult->first_chat, 60);


                $fix = FixedService::where('consult_id', $consult->id)->where('buy_user', $consulting_user->id)->first();
                $consult->fix_id = $fix->id;
                $consult->estimate = $fix->estimate;
                $consult->contract = $fix->contract;
            }
        }

        return view('service.provider.list', compact('items', 'requests', 'consults'));
    }

    public function getMyServiceEdit($service_id)
    {
        $item = Service::where('id', $service_id)->first();

        if ($item->public_sign == true) {
            $item->public = "公開中";
        } else {
            $item->public = "非公開中";
        }

        if ($item->category_ids) {
            $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();
        }

        if ($item->area_id) {
            $item->area_ids = Area::whereIn('id', $item->area_id)->get();
        }

        $categories = ServiceCategory::get();
        $areas = Area::get();

        return view('service.provider.edit', compact('item', 'categories', 'areas'));
    }

    public function updateMyService(Request $request)
    {
        if ($request->public_sign == 1) {
            $public = true;
        } else {
            $public = false;
        }

        $service = Service::where('id', $request->service_id)->first();

        $service->main_title = $request->main_title;
        $service->content = $request->content;
        $service->category_ids = $request->category_ids;
        $service->area_id = $request->area_id;
        $service->attention = $request->attention;
        $service->public_sign = $public;
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

        return redirect()->route('search.more', ['service_id' => $request->service_id]);
    }

    ///////////////////////////////////////
    ////////公開依頼の検索について////////////
    public function getPubReq()
    {
        $items = Service::whereNotNull('request_user_id')
            ->orderBy('created_at')
            ->get();


        foreach ($items as $item) {
            if ($item->category_ids) {
                $category = ServiceCategory::where('id', $item->category_ids)->first();
                $item->category_name = $category->name;
            }

            if ($item->area_id) {
                $area = Area::where('id', $item->area_id)->first();
                $item->area_name = $area->name;
            }

            $user = User::where('id', $item->request_user_id)->first();
            $item->profile_img = $user->img_url;
            $item->user_name = $user->nickname;

            if (Auth::check()) {
                $user_id = Auth::id();
                $item->entry = Entry::where('service_id', $item->id)->where('sell_user', $user_id)->first();
            }
        }

        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view('public_request.index', compact('items', 'areas', 'categories'));
    }

    public function searchPubReq(Request $request)
    {
        $items = Service::whereNotNull('request_user_id')
            ->orderBy('created_at')
            ->get();

        if ($request->category_ids) {
            $search_category = Service::where(function ($query) use ($request) {
                foreach ($request->category_ids as $categoryId) {
                    $query->orWhereJsonContains('category_ids', $categoryId);
                }
            })->get();
        } else {
            $search_category = Service::get();
        }

        if ($request->area_id) {
            $search_prefecture = Service::where(function ($query) use ($request) {
                foreach ($request->area_id as $areaId) {
                    $query->orWhereJsonContains('area_id', $areaId);
                }
            })->get();
        } else {
            $search_prefecture = Service::get();
        }

        if ($request->price_min  == null) {
            if ($request->price_max == null) {
                $search_prices = Service::get();
            } else {
                $search_prices = Service::where('price', '<=', $request->price_max)->get();
            }
        } else {
            if ($request->price_max == null) {
                $search_prices = Service::where('price', '>=', $request->price_min)->get();
            } else {
                $search_prices = Service::whereBetween('price', [$request->price_min, $request->price_max])->get();
            }
        }

        //全ての検索結果（空欄も含める）に共通する$itemsを絞る
        $items = $items->intersect($search_category)->intersect($search_prefecture)->intersect($search_prices);

        foreach ($items as $item) {
            if ($item->category_ids) {
                $category = ServiceCategory::where('id', $item->category_ids)->first();
                $item->category_name = $category->name;
            }

            if ($item->area_id) {
                $area = Area::where('id', $item->area_id)->first();
                $item->area_name = $area->name;
            }

            $user = User::where('id', $item->request_user_id)->first();
            $item->profile_img = $user->img_url;
            $item->user_name = $user->nickname;

            if (Auth::check()) {
                $user_id = Auth::id();
                $item->entry = Entry::where('service_id', $item->id)->where('sell_user', $user_id)->first();
            }
        }

        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view('public_request.search', compact('items', 'areas', 'categories', 'request'));
    }

    public function moreSearch($service_id)
    {
        $user_id = Auth::id();
        $item = Service::where('id', $service_id)->first();
        $buy_user = User::where('id', $item->request_user_id)->first();

        $item->user_name = $buy_user->nickname;
        $item->img_url = $buy_user->img_url;
        $living = Area::where('id', $buy_user->living_area)->first();
        $item->living_area = $living->name;
        $item->age =
            Carbon::parse($buy_user->birthday)->age;

        if ($item->public_sign == true) {
            $item->public = "公開中";
        } else {
            $item->public = "非公開中";
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

        $room = ChatRoom::where('service_id', $service_id)->where('sell_user', $user_id)->where('buy_user', $buy_user->id)->first();
        if($room){
            $room_id = $room->id;
        }else {
            $room_id = null;
        }

        $entry = Entry::where('service_id', $service_id)->where('buy_user', $buy_user->id)->where('sell_user', $user_id)->first();
        if($entry){
            $entry_id = $entry->id;
            $item->status = $entry->status;
        }else {
            $entry_id = null;
        }

        $edit_flags = Entry::where('service_id', $service_id)->where('buy_user', $user_id)->get();
        if($edit_flags) {
            $item->edit = true;
            foreach ($edit_flags as $edit_flag) {
                if ($edit_flag->status == 'approved' || $edit_flag->status == 'paid' || $edit_flag->status == 'estimate') {
                    $item->edit = false;
                    break;
                }
            }
        }

        $entrieds = Entry::where('service_id', $service_id)        ->where('buy_user', $user_id)
                            ->whereNotIn('status', ['pending'])
                            ->get();

        foreach ($entrieds as $entried){
            $entried_user = User::where('id', $entried->sell_user)->first();
            $entried->user_name = $entried_user->nickname;
            $entried->profile_image = $entried_user->img_url;
            $entried->message = $entried_user->message;
            $entried->gender = '男性';
            if($entried_user->gender =='2'){
                $entried->gender = '女性';
            }elseif($entried_user->gender == '3'){
                $entried->gender = 'その他';
            }
        }

        return view('public_request.detail', compact('item', 'user_id', 'room_id', 'entry_id', 'entrieds'));
    }
}
