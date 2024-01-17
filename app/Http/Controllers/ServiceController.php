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
use App\Models\Information;
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
            ->where('type', 'service')
            ->where('status', 'open')
            ->take(15)
            ->get();
        foreach($items as $item){
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
            $item->profider_id = $provider->id;
        }

        //公開依頼の表示について
        $public_requests = Service::orderBy('created_at', 'desc')
        ->where('type', 'public_request')
        ->where('status', 'open')
        ->take(15)
        ->get();
        foreach ($public_requests as $public_request) {
            if ($public_request->category_ids) {
                $public_request->categories = ServiceCategory::whereIn('id', $public_request->category_ids)->get();

                foreach ($public_request->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $seeker = User::where('id', $public_request->request_user_id)->first();

            $public_request->profile_image = $seeker->img_url;
            $public_request->seeker_id = $seeker->id;
            $public_request->seeker_name = $seeker->nickname;
        }

        $categories = ServiceCategory::get();

        $info_1 = Information::where('status', 'public')->orderBy('id', 'desc')->first();
        $info_2 = Information::where('status', 'public')->where('id', '<', $info_1->id)->orderBy('id', 'desc')->first();
        $info_3 = Information::where('status', 'public')->where('id', '<', $info_2->id)->orderBy('id', 'desc')->first();

        return view('index', compact('items','categories', 'public_requests','info_1', 'info_2', 'info_3'));
    }
    
    public function getRequest()
    {

        return view('request.index');
    }

    public function service()
    {
        $user_id = Auth::id();
        $items = Service::orderBy('created_at', 'desc')
            ->where('type', 'service')
            ->where('status', 'open')
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
            'service.seeker.index',
            compact('items', 'categories', 'areas')
        );
    }

    public function searchService(Request $request){

        $items = Service::orderBy('created_at', 'desc')
        ->where('type', 'service')
        ->where('status', 'open')
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
                $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

                foreach ($item->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $provider = User::where('id', $item->offer_user_id)->first();

            $item->profile_image = $provider->img_url;
            $item->provider_name = $provider->nickname;

            if ($item->area_id) {
                $area = Area::where('id', $item->area_id)->first();
                $item->area_name = $area->name;
            }
        }

        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view('service.seeker.search', compact('items', 'areas', 'categories', 'request'));
    }

    public function showUser($user_id)
    {
    }

    public function showDetail($service_id)
    {
        $item = Service::where('id', $service_id)->first();

        $sell_user = User::where('id', $item->offer_user_id)->first();
        $item->user_name = $sell_user->nickname;
        $item->img_url = $sell_user->img_url;
        $item->provider_id = $sell_user->id;
        $living = Area::where('id', $sell_user->living_area)->first();
        if($living){
        $item->living_area = $living->name;
        }
        $item->age =
            Carbon::parse($sell_user->birthday)->age;

        if ($item->status == 'open') {
            $item->status_name = "公開中";
        } elseif($item->status == 'closed') {
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

        $user_id = Auth::id();
        if($sell_user->id !== $user_id){
            $room = ChatRoom::where('service_id', $service_id)->where('sell_user', $sell_user->id)->where('buy_user', $user_id)->first();
            if ($room) {
                $room_id = $room->id;
            } else {
                $room_id = null;
            }

            $entry = Entry::where('service_id', $service_id)->where('buy_user', $user_id)->where('sell_user', $sell_user->id)->first();
            if ($entry) {
                $entry_id = $entry->id;
                $item->status = $entry->status;
            } else {
                $entry_id = null;
            }
        }else{
            $entry = Entry::where('service_id', $service_id)->where('sell_user', $user_id)->get();
            
            $room_id = null;

        }


        $item->favorite = Favorite::where('favorite_id', $item->id)->where('user_id', $user_id)->exists();

        $item->follow = Follow::where('follow_id', $item->offer_user_id)->where('user_id', $user_id)->exists();


        return view(
            'service.seeker.detail',
            compact('item', 'entry', 'room_id','user_id')
        );
    }

    public function requestCreate()
    {
        $user_id = Auth::id();
        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view(
            'public_request.create',
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

    public function ServiceDone(Request $request)
    {
        //validate
        $validatedData = $request->validate([
            'main_title' => 'required|max:20',
            'content' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);


        $service = new Service();

        if ($request->hasFile('photo_1')) {
            $dir = 'service';
            $file = $request->file('photo_1');
            $file_name = $request->file('photo_1')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_1 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_1')->storeAs('public/' . $dir, $file_name);
            $service->photo_1 = $path_1;
        }else{
            $service->photo_1 = 'storage/profile/no_image.jpg';
        }
        if ($request->hasFile('photo_2')) {
            $dir = 'service';
            $file = $request->file('photo_2');
            $file_name = $request->file('photo_2')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_2 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_2')->storeAs('public/' . $dir, $file_name);
            $service->photo_2 = $path_2;
        }
        if ($request->hasFile('photo_3')) {
            $dir = 'service';
            $file = $request->file('photo_3');
            $file_name = $request->file('photo_3')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_3 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_3')->storeAs('public/' . $dir, $file_name);
            $service->photo_3 = $path_3;
        }
        if ($request->hasFile('photo_4')) {
            $dir = 'service';
            $file = $request->file('photo_4');
            $file_name = $request->file('photo_4')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_4 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_4')->storeAs('public/' . $dir, $file_name);
            $service->photo_4 = $path_4;
        }
        if ($request->hasFile('photo_5')) {
            $dir = 'service';
            $file = $request->file('photo_5');
            $file_name = $request->file('photo_5')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_5 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_5')->storeAs('public/' . $dir, $file_name);
            $service->photo_5 = $path_5;
        }
        if ($request->hasFile('photo_6')) {
            $dir = 'service';
            $file = $request->file('photo_6');
            $file_name = $request->file('photo_6')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_6 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_6')->storeAs('public/' . $dir, $file_name);
            $service->photo_6 = $path_6;
        }
        if ($request->hasFile('photo_7')) {
            $dir = 'service';
            $file = $request->file('photo_7');
            $file_name = $request->file('photo_7')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_7 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_7')->storeAs('public/' . $dir, $file_name);
            $service->photo_7 = $path_7;
        }
        if ($request->hasFile('photo_8')) {
            $dir = 'service';
            $file = $request->file('photo_8');
            $file_name = $request->file('photo_8')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_8 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_8')->storeAs('public/' . $dir, $file_name);
            $service->photo_8 = $path_8;
        }

        if($request->status ==1){
            $status = 'open';
        }elseif($request->status == 2){
            $status = 'closed';
        }
        $service->offer_user_id = $request->user_id;
        $service->type = $request->type;
        $service->main_title = $validatedData['main_title'];
        $service->content = $validatedData['content'];
        $service->category_ids = $request->category_id;
        $service->attention = $request->attention;
        $service->free = $request->free;
        $service->price = $validatedData['price'];
        $service->price_net = ($request->price) * 0.9;
        $service->application_deadline = $request->applying_deadline;
        $service->delivery_deadline = $request->delivery_deadline;
        $service->area_id = $request->area_id;
        $service->status = $status;
        $service->save();

        return redirect()->route('mypage.service.list');
    }

    public function PubreqDone(Request $request)
    {
        //validate
        $validatedData = $request->validate([
            'main_title' => 'required|max:20',
            'content' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);
        
        $service = new Service();

        if ($request->hasFile('photo_1')) {
            $dir = 'service';
            $file = $request->file('photo_1');
            $file_name = $request->file('photo_1')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_1 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_1')->storeAs('public/' . $dir, $file_name);
            $service->photo_1 = $path_1;
        }
        if ($request->hasFile('photo_2')) {
            $dir = 'service';
            $file = $request->file('photo_2');
            $file_name = $request->file('photo_2')->getClientOriginalName();
            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }
            $path_2 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_2')->storeAs('public/' . $dir, $file_name);
            $service->photo_2 = $path_2;
        }
        if ($request->hasFile('photo_3')) {
            $dir = 'service';
            $file = $request->file('photo_3');
            $file_name = $request->file('photo_3')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_3 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_3')->storeAs('public/' . $dir, $file_name);
            $service->photo_3 = $path_3;
        }
        if ($request->hasFile('photo_4')) {
            $dir = 'service';
            $file = $request->file('photo_4');
            $file_name = $request->file('photo_4')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_4 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_4')->storeAs('public/' . $dir, $file_name);
            $service->photo_4 = $path_4;
        }
        if ($request->hasFile('photo_5')) {
            $dir = 'service';
            $file = $request->file('photo_5');
            $file_name = $request->file('photo_5')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_5 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_5')->storeAs('public/' . $dir, $file_name);
            $service->photo_5 = $path_5;
        }
        if ($request->hasFile('photo_6')) {
            $dir = 'service';
            $file = $request->file('photo_6');
            $file_name = $request->file('photo_6')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_6 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_6')->storeAs('public/' . $dir, $file_name);
            $service->photo_6 = $path_6;
        }
        if ($request->hasFile('photo_7')) {
            $dir = 'service';
            $file = $request->file('photo_7');

            $file_name = $request->file('photo_7')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_7 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_7')->storeAs('public/' . $dir, $file_name);
            $service->photo_7 = $path_7;
        }
        if ($request->hasFile('photo_8')) {
            $dir = 'service';
            $file = $request->file('photo_8');
            $file_name = $request->file('photo_8')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

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
        $service->offer_user_id = $request->user_id;
        $service->type = $request->type;
        $service->main_title = $request->main_title;
        $service->content = $request->content;
        $service->category_ids = $request->category_id;
        $service->attention = $request->attention;
        $service->free = $request->free;
        $service->price = $request->price;
        $service->price_net = ($request->price) * 0.9;
        $service->application_deadline = $request->application_deadline;
        $service->delivery_deadline = $request->delivery_deadline;
        $service->area_id = $request->area_id;
        $service->status = 'open';
        $service->save();

        return redirect()->route('mypage.pubreq.list');
    }

    public function edit($service_id)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
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

        $room = null;
        if ($consults = Entry::where('sell_user', $user_id)->get()) {
            $consults = Entry::where('sell_user', $user_id)->get();

            //sell_user=自分
            foreach ($consults as $consult) {
                $consulted_service = Service::where('id', $consult->service_id)->first();
                $consult->service_name = $consulted_service->main_title;

                $consulted_user = User::where('id', $consult->buy_user)->first();
                $consult->consulted_user_name = $consulted_user->nickname;
                $consult->profile_img = $consulted_user->img_url;
                $consult->consulted_user_id = $consulted_user->id;

                $consult->first_chat = Str::limit($consult->first_chat, 60);

                $room = ChatRoom::where('service_id', $consult->service_id)
                ->where('buy_user', $consulted_user->id)
                ->where('sell_user', $user_id)
                ->first();
            }
        }

        return view('service.provider.list', compact('items', 'consults', 'room'));
    }

    public function getMyPubreqList(){
        $user_id = Auth::id();

        $requests = Service::where('request_user_id', $user_id)->get();
        foreach ($requests as $request) {
            $request->content = Str::limit($request->content, 60);
        }

        $room = null;
        if ($consults = Entry::where('buy_user', $user_id)->get()) {
            $consults = Entry::where('buy_user', $user_id)->get();

            //buy_user=自分
            foreach ($consults as $consult) {
                $consulted_service = Service::where('id', $consult->service_id)->first();
                $consult->service_name = $consulted_service->main_title;

                $consulting_user = User::where('id', $consult->sell_user)->first();
                $consult->consulting_user_name = $consulting_user->nickname;
                $consult->profile_img = $consulting_user->img_url;
                $consult->consulting_user_id = $consulting_user->id;

                $consult->first_chat = Str::limit($consult->first_chat, 60);

                $room = ChatRoom::where('service_id', $consult->service_id)
                    ->where('sell_user', $consulting_user->id)
                    ->where('buy_user', $user_id)
                    ->first();
            }
        }

        return view('service.seeker.list', compact('requests', 'consults', 'room'));
    }

    public function getMyServiceEdit($service_id)
    {
        $item = Service::where('id', $service_id)->first();

        if ($item->status == 'open') {
            $item->status_name = "公開中";
        } elseif($item->status == 'closed') {
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

        return view('service.provider.edit', compact('item', 'categories', 'areas'));
    }

    public function updateMyService(Request $request)
    {
        if ($request->status == 1) {
            $status = 'open';
        } elseif($request->status == 2) {
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
            $file = $request->file('photo_1');
            $file_name = $request->file('photo_1')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_1 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_1')->storeAs('public/' . $dir, $file_name);
            $service->photo_1 = $path_1;
        }
        if ($request->hasFile('photo_2')) {
            $dir = 'service';
            $file = $request->file('photo_2');
            $file_name = $request->file('photo_2')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_2 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_2')->storeAs('public/' . $dir, $file_name);
            $service->photo_2 = $path_2;
        }
        if ($request->hasFile('photo_3')) {
            $dir = 'service';
            $file = $request->file('photo_3');
            $file_name = $request->file('photo_3')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_3 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_3')->storeAs('public/' . $dir, $file_name);
            $service->photo_3 = $path_3;
        }
        if ($request->hasFile('photo_4')) {
            $dir = 'service';
            $file = $request->file('photo_4');
            $file_name = $request->file('photo_4')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_4 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_4')->storeAs('public/' . $dir, $file_name);
            $service->photo_4 = $path_4;
        }
        if ($request->hasFile('photo_5')) {
            $dir = 'service';
            $file = $request->file('photo_5');
            $file_name = $request->file('photo_5')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_5 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_5')->storeAs('public/' . $dir, $file_name);
            $service->photo_5 = $path_5;
        }
        if ($request->hasFile('photo_6')) {
            $dir = 'service';
            $file = $request->file('photo_6');
            $file_name = $request->file('photo_6')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_6 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_6')->storeAs('public/' . $dir, $file_name);
            $service->photo_6 = $path_6;
        }
        if ($request->hasFile('photo_7')) {
            $dir = 'service';
            $file = $request->file('photo_7');
            $file_name = $request->file('photo_7')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_7 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_7')->storeAs('public/' . $dir, $file_name);
            $service->photo_7 = $path_7;
        }
        if ($request->hasFile('photo_8')) {
            $dir = 'service';
            $file = $request->file('photo_8');
            $file_name = $request->file('photo_8')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_8 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_8')->storeAs('public/' . $dir, $file_name);
            $service->photo_8 = $path_8;
        }
        $service->save();

        return redirect()->route('service.detail', ['service_id' => $request->service_id]);
    }

    ///////////////////////////////////////
    ////////公開依頼の検索について////////////
    public function getPubReq()
    {
        $items = Service::orderBy('created_at', 'desc')
            ->where('type', 'public_request')
            ->where('status', 'open')
            ->get();


        foreach ($items as $item) {
            if ($item->category_ids) {
                $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

                foreach ($item->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $provider = User::where('id', $item->request_user_id)->first();

            $item->profile_image = $provider->img_url;
            $item->provider_name = $provider->nickname;
        }

        $areas = Area::get();
        $categories = ServiceCategory::get();

        return view('public_request.index', compact('items', 'areas', 'categories'));
    }

    public function searchPubReq(Request $request)
    {
        $items = Service::orderBy('created_at', 'desc')
            ->where('type', 'service')
            ->where('status', 'open')
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
                $item->categories = ServiceCategory::whereIn('id', $item->category_ids)->get();

                foreach ($item->categories as $value) {
                    $data = ServiceCategory::where('id', $value->id)->first();
                    $value->category_name = $data->name;
                }
            }
            $provider = User::where('id', $item->offer_user_id)->first();

            $item->profile_image = $provider->img_url;
            $item->provider_name = $provider->nickname;
            $item->provider_id = $provider->id;

            if ($item->area_id) {
                $area = Area::where('id', $item->area_id)->first();
                $item->area_name = $area->name;
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
        $item->user_id = $buy_user->id;
        $living = Area::where('id', $buy_user->living_area)->first();
        $item->living_area = $living->name;
        $item->age =
            Carbon::parse($buy_user->birthday)->age;

        if ($item->status == 'open') {
            $item->status_name = "公開中";
        } elseif ($item->status == 'closed')  {
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
                            ->where('status', 'estimate')
                            ->get();

        return view('public_request.detail', compact('item', 'user_id', 'room_id', 'entry_id', 'entrieds'));
    }

    public function editPubreq($service_id)
    {
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

        return view('public_request.edit', compact('item', 'categories', 'areas'));
    }

    public function update(Request $request)
    {
        //validate
        $validatedData = $request->validate([
            'main_title' => 'required|max:20',
            'content' => 'required',
            'price' => 'required',
            'category_ids' => 'required'
        ]);

        if ($request->status == 1) {
            $status = 'open';
        } elseif ($request->status == 2) {
            $status = 'closed';
        }

        $service = Service::where('id', $request->service_id)->first();

        $service->main_title = $validatedData['main_title'];
        $service->content = $validatedData['content'];
        $service->category_ids = $request->category_ids;
        $service->area_id = $request->area_id;
        $service->attention = $request->attention;
        $service->status = $status;
        $service->price = $validatedData['price'];
        $service->price_net = $request->price*0.9;
        $service->delivery_deadline = $request->delivery_deadline;
        $service->application_deadline = $request->application_deadline;
        $service->free = $request->free;

        if ($request->hasFile('photo_1')) {
            $dir = 'service';
            $file = $request->file('photo_1');
            $file_name = $request->file('photo_1')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_1 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_1')->storeAs('public/' . $dir, $file_name);
            $service->photo_1 = $path_1;
        }
        if ($request->hasFile('photo_2')) {
            $dir = 'service';
            $file = $request->file('photo_2');
            $file_name = $request->file('photo_2')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_2 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_2')->storeAs('public/' . $dir, $file_name);
            $service->photo_2 = $path_2;
        }
        if ($request->hasFile('photo_3')) {
            $dir = 'service';
            $file = $request->file('photo_3');
            $file_name = $request->file('photo_3')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

            $path_3 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_3')->storeAs('public/' . $dir, $file_name);
            $service->photo_3 = $path_3;
        }
        if ($request->hasFile('photo_4')) {
            $dir = 'service';
            $file = $request->file('photo_4');
            $file_name = $request->file('photo_4')->getClientOriginalName();

            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }
            
            $path_4 = 'storage/' . $dir . '/' . $file_name;
            $request->file('photo_4')->storeAs('public/' . $dir, $file_name);
            $service->photo_4 = $path_4;
        }
        
        $service->save();

        return redirect()->route('pubreq.detail', ['service_id' => $request->service_id]);
    }
}
