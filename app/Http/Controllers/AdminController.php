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
use App\Models\Cancel;
use App\Models\Identification;
use App\Models\Information;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use App\Models\BankAccount;
use Illuminate\Support\Carbon;
use App\Notifications\BuyerAdminApproved;
use App\Notifications\SellerAdminApproved;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->type !== 'admin'){
            return redirect()->route('toppage');
        }

        $info_1 = Information::where('status', 'public')->orderBy('id', 'desc')->first();
        $info_2 = Information::where('status', 'public')->where('id', '<', $info_1->id)->orderBy('id', 'desc')->first();
        $info_3 = Information::where('status', 'public')->where('id', '<', $info_2->id)->orderBy('id', 'desc')->first();


        return view('admin.index', compact('info_1', 'info_2', 'info_3'));
    }

    public function informationsEdit(){
        $info_1 = Information::where('status', 'public')->orderBy('id', 'desc')->first();
        $info_2 = Information::where('status', 'public')->where('id', '<', $info_1->id)->orderBy('id', 'desc')->first();
        $info_3 = Information::where('status', 'public')->where('id', '<', $info_2->id)->orderBy('id', 'desc')->first();



        $informations = Information::get();
        foreach ($informations as $information){
            if($information->status == 'public'){
                $information->status_name = '公開';
            }else{
                $information->status_name = '非公開';
            }
        }

        return view('admin.information.edit', compact('info_1', 'info_2', 'info_3', 'informations'));
    }

    public function informationsUpdate(Request $request){
        try{
        $informationId = $request->input('information_id');
        $status = $request->input('status');
        $title = $request->input('title');
        $content = $request->input('content');

        $information = Information::where('id', $informationId)->first();
        $information->status = $status;
        $information->title = $title;
        $information->content = $content;
        $information->save();

        return response()->json(['message' => '更新が完了しました']);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function informationsCreate(Request $request){
        $information = new Information();
        $information->title = $request->title;
        $information->content = $request->content;
        $information->status = 'public';
        $information->save();

        return redirect()->back();
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
            $file = $request->file('image');
            $file_name = $request->file('image')->getClientOriginalName();
            // ファイル名の重複をチェックする
            $counter = 1;
            while (file_exists('storage/' . $dir . '/' . $file_name)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . $counter . '.' . $file->getClientOriginalExtension();
                $counter++;
            }

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

        return redirect()->route('admin.service.detail', ['service_id' => $request->service_id]);
    }

    public function userChatList(){
        $items = ChatRoom::get()->filter(function ($item) {
            $item->chat = Chat::where('room_id', $item->id)->orderByDesc('created_at')->first();
            return $item->chat;
        })->sortByDesc(function ($item) {
            return $item->chat->created_at;
        });

        foreach ($items as $item) {
            $service = Service::where('id', $item->service_id)->first();
            $item->service_name = $service->main_title;

            $buy_user = User::where('id', $item->buy_user)->first();
            $sell_user = User::where('id', $item->sell_user)->first();
            $item->buy_user = $buy_user->nickname;
            $item->sell_user = $sell_user->nickname;

            $item->create = Chat::where('room_id', $item->id)->orderBy('created_at', 'desc')->pluck('created_at')->first()->format('Y年m月d日 H時i分');
            if($item->status == 'stopping'){
                $item->stopping = '強制停止中';
            }

            if (Entry::where('service_id', $item->service_id)->where('buy_user', $buy_user->id)->where('sell_user', $sell_user->id)->exists()) {
                $entry = Entry::where('service_id', $item->service_id)->where('buy_user', $buy_user->id)->where('sell_user', $sell_user->id)->first();

                if ($entry->status == 'pending') {
                    $item->entry_status = '相談中';
                } elseif ($entry->status == 'approved') {
                    $item->entry_status = '依頼中';
                } elseif ($entry->status == 'unapproved') {
                    $item->entry_status = '依頼非成立';
                } elseif ($entry->status == 'paid') {
                    $item->entry_status = '支払い対応済み';
                } elseif ($entry->status == 'delivered') {
                    $item->entry_status = '納品済み';
                }
            } else {
                $item->entry_status = null;
            }
        }
        return view('admin.user_chat.list', compact('items'));
    }

    public function userChatRoom($room_id){
        $room = ChatRoom::where('id', $room_id)->first();
        $sell_user = User::where('id', $room->sell_user)->first();
        $buy_user = User::where('id', $room->buy_user)->first();
        //チャット内容の表示
        $chats = Chat::where('room_id', $room_id)->get();
        foreach ($chats as $chat) {
            $sender = User::where('id', $chat->sender_id)->first();
            $chat->nickname = $sender->nickname;
            $chat->img_url = $sender->img_url;
        }

        return view('admin.user_chat.room',compact('chats', 'sell_user', 'buy_user', 'room'));
    }

    public function postUserChat(Request $request){
        if (is_null($request->input('message')) && !$request->hasFile('file_path')) {
            return redirect()->back()->with('error', 'メッセージまたは画像を選択してください。');
        }

        $chat = new Chat;
        // 画像ファイルを保存する処理
        $chat->room_id = $request->room_id;
        $chat->sender_id = $request->sender_id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->input('message');
        if ($request->hasFile('file_path')) {
            $dir = 'in_chat';
            $file = $request->file('file_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $filename);
            $chat->file = 'storage/in_chat/' . $filename;
        }
        $chat->save();
        return redirect()->back();
    }

    public function stopUserChat(Request $request){
        $chat_room = ChatRoom::where('id', $request->room_id)->first();

        $chat_room->status = 'stopping';
        $chat_room->save();

        return redirect()->back();
    }

    public function unstopUserChat(Request $request){
        $chat_room = ChatRoom::where('id', $request->room_id)->first();

        $chat_room->status = null;
        $chat_room->save();

        return redirect()->back();
    }

    public function cancelOfferList(){
        $items = Cancel::where('status', 'pending')->get();
        
        foreach ($items as $item){
            $agreement = Agreement::where('id', $item->agreement_id)->first();

            $item->main_title = $agreement->main_title;
            $entry = Entry::where('id', $agreement->entry_id)->first();
            $buy_user = User::where('id', $agreement->buy_user)->first();
            $sell_user = User::where('id', $agreement->sell_user)->first();
            $item->buy_user_name = $buy_user->nickname;
            $item->sell_user_name = $sell_user->nickname;

            $payment = Payment::where('id', $item->payment_id)->first();
            $item->include_tax_price = $payment->include_tax_price;
            $item->payment_date = $payment->created_at;

            $item->payment_id = $payment->id;

            if($agreement->status == 'canceled'){
                $item->status_name = 'キャンセル済み';
            }elseif($agreement->status == 'cancel_pending'){
                $item->status_name ='未対応';
            }elseif($agreement->status == 'paid'){
                $item->status_name = 'キャンセル取り消し済み';
            }
        }

        return view('admin.cancel.offer_list',compact('items'));
    }

    public function cancelOfferDetail($cancel_id){
        $item = Cancel::where('id', $cancel_id)->first();
        $agreement = Agreement::where('id', $item->agreement_id)->first();
        $item->main_title = $agreement->main_title;
        $item->buy_user_name = User::where('id', $agreement->buy_user)->value('nickname');
        $item->sell_user_name = User::where('id', $agreement->sell_user)->value('nickname');

        $payment = Payment::where('id', $item->payment_id)->first();
        $item->include_tax_price = $payment->include_tax_price;

        if($agreement->status == 'cancel_pending'){
            $item->status_name = 'cancel_pending';
        }elseif($agreement->status == 'canceled'){
            $item->status_name = 'canceled';
        }elseif($agreement->status == 'paid'){
            $item->status_name = 'paid';
        }

        
        return view('admin.cancel.offer_detail', compact('item'));
    }

    public function approveCancel(Request $request){
        $cancel = Cancel::where('id', $request->cancel_id)->first();
        $payment= Payment::where('id', $cancel->payment_id)->first();
        $agreement = Agreement::where('id', $payment->agreement_id)->first();
        $entry = Entry::where('id', $agreement->entry_id)->first();

        $entry->status = 'canceled';
        $entry->save();

        $agreement->status = 'canceled';
        $agreement->save();

        $payment->cancel_fee = $payment->include_tax_price;
        $payment->save();

        $cancel->refund = 'approved';
        $cancel->save();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $agreement->main_title . 'のキャンセルが承認されました',
            'description' =>  'キャンセル済み',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_s = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_s->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>
            $agreement->main_title . 'のキャンセルが承認されました',
            'description' =>  'キャンセル済み',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        $buyer = User::where('id', $agreement->buy_user)->first();
        $buyerName = $buyer->nickname;
        $seller = User::where('id', $agreement->sell_user)->first();
        $sellerName = $seller->nickname;
        //購入者へのNotification
        $buyer->notify(new BuyerAdminApproved($buyerName, $sellerName));

        //支払い者へのNotification
        $seller->notify(new SellerAdminApproved($buyerName, $sellerName));

        return redirect()->route('admin.cancel.offer.detail',['cancel_id'=> $cancel->id]);
    }

    public function unapproveCancel(Request $request)
    {
        $cancel = Cancel::where('id', $request->cancel_id)->first();
        $payment = Payment::where('id', $cancel->payment_id)->first();
        $agreement = Agreement::where('id', $payment->agreement_id)->first();
        $entry = Entry::where('id', $agreement->entry_id)->first();

        $entry->status = 'paid';
        $entry->save();

        $agreement->status = 'paid';
        $agreement->save();

        $cancel->refund = 'not_haveto_refund';
        $cancel->save();

        //sell_userへのアナウンス
        $announcement_s = new Announcement([
            'title' =>  $agreement->main_title . 'のキャンセルは認められませんでした。',
            'description' =>  'キャンセルできてません',
            'link' => 'mypage.service.list',
        ]);
        $announcement_s->save();

        $announcementRead_s = new AnnouncementRead([
            'user_id' => $agreement->sell_user,
            'announcement_id' => $announcement_s->id,
            'read' => false
        ]);
        $announcementRead_s->save();

        //buy_userへのメッセージ
        $announcement_b = new Announcement([
            'title' =>
            $agreement->main_title . 'のキャンセルは認められませんでした',
            'description' =>  'キャンセルできてません',
            'link' => 'chat.list',
        ]);
        $announcement_b->save();

        $announcementRead_b = new AnnouncementRead([
            'user_id' => $agreement->buy_user,
            'announcement_id' => $announcement_b->id,
            'read' => false
        ]);
        $announcementRead_b->save();

        return redirect()->route('admin.cancel.offer.detail', ['cancel_id' => $cancel->id]);
    }

    //本人確認証明書の確認依頼_リスト表示
    public function identificationOfferList(){
        $items = Identification::orderBy('created_at', 'desc')
        ->where('identification_agreement', 'pending')
        ->get();

        foreach($items as $item){
            $user = User::where('id', $item->user_id)->first();
            $item->user_nickname = $user->nickname;
            $item->user_name = $user->name;
            $item->user_id = $user->id;
            $item->profile_image = $user->img_url;
        }

        return view('admin.user.identification.offer_list', compact('items'));
    }

    public function identificationDetail($identification_id){
        $item = Identification::where('id', $identification_id)->first();

        if($item->identification_agreement == 'pending'){
            $item->status = '確認未対応';
        }elseif($item->identification_agreement == 'approved'){
            $item->status = '承認済み';
        }else{
            $item->status = '否認済み';
        }
        $user = User::where('id', $item->user_id)->first();
        $item->user_name = $user->name;
        $item->user_nickname = $user->nickname;
        if ($user->gender == 1) {
            $item->gender = "男性";
        } elseif ($user->gender == 2) {
            $item->gender = "女性";
        } else {
            $item->gender = "未設定";
        }

        $another_items = Identification::where('user_id',$user->id)->get();

        $hasOtherItems = $another_items->contains(function ($value) use ($item) {
            return $value->id !== $item->id;
        });
        if ($hasOtherItems == true) {
            // $another_itemsに$item以外の要素が存在する場合の処理
            $other_items = $another_items->reject(
                function ($value) use ($item) {
                    return $value->id === $item->id;
                });        

            foreach($other_items as $other_item){
                if ($other_item->identification_agreement == 'pending') {
                    $other_item->status = '確認未対応';
                } elseif ($other_item->identification_agreement == 'approved') {
                    $other_item->status = '承認済み';
                } else {
                    $other_item->status = '否認済み';
                }
            }
        }else{
            $other_items = null;
        }

        return view('admin.user.identification.detail', compact('item', 'other_items'));
    }

    public function identificationApproved(Request $request){
        $identification = Identification::where('id', $request->identification_id)->first();

        $identification->identification_agreement = 'approved';
        $identification->save();

        return redirect()->back();
    }

    public function identificationUnapproved(Request $request)
    {
        $identification = Identification::where('id', $request->identification_id)->first();

        $identification->identification_agreement = 'unapproved';
        $identification->save();

        return redirect()->back();
    }

    public function identificationApprovedList(){
        $items = Identification::orderBy('created_at', 'desc')
        ->where('identification_agreement', 'approved')
        ->get();

        foreach ($items as $item) {
            $user = User::where('id', $item->user_id)->first();
            $item->user_nickname = $user->nickname;
            $item->user_name = $user->name;
            $item->user_id = $user->id;
            $item->profile_image = $user->img_url;
        }

        return view('admin.user.identification.approved_list', compact('items'));
    }

    public function identificationUnpprovedList()
    {
        $items = Identification::orderBy('created_at', 'desc')
        ->where('identification_agreement', 'unapproved')
        ->get();

        foreach ($items as $item) {
            $user = User::where('id', $item->user_id)->first();
            $item->user_nickname = $user->nickname;
            $item->user_name = $user->name;
            $item->user_id = $user->id;
            $item->profile_image = $user->img_url;
        }

        return view('admin.user.identification.unapproved_list', compact('items'));
    }

    //振込申請
    public function adminTransferList()
    {
        $items = Payment::get();

        foreach ($items as $item) {
            $user = User::where('id', $item->sell_user)->first();
            $item->user_id = $user->id;
            $item->nickname = $user->nickname;

            if ($item->transfer == 'applied') {
                $item->status_name = '振込申請済み';
            } elseif ($item->transfer == 'unapplied') {
                $item->status_name = '未申請';
            } elseif ($item->transfer == 'transferred') {
                $item->status_name = '振込済み';
            }

            $item->transfer_price = $item->price * 0.9 - $item->cancel_fee;
            if($item->transfer_price < 0){
                $item->transfer_price = 0;
            }
        }

        return view('admin.transfer.list', compact('items'));
    }

    public function adminTransferOfferList()
    {
        $items = Payment::where('transfer', 'applied')
        ->get();

        foreach ($items as $item) {
            $user = User::where('id', $item->sell_user)->first();
            $item->user_id = $user->id;
            $item->nickname = $user->nickname;

            if ($item->transfer == 'applied') {
                $item->status_name = '振込申請済み';
            } elseif ($item->transfer == 'unapplied') {
                $item->status_name = '未申請';
            } elseif ($item->transfer == 'transferred') {
                $item->status_name = '振込済み';
            }

            $item->transfer_price = $item->price * 0.9 - $item->cancel_fee;
            if ($item->transfer_price < 0) {
                $item->transfer_price = 0;
            }
        }

        return view('admin.transfer.offer_list', compact('items'));
    }

    public function adminTransferDoneList()
    {
        $items = Payment::where('transfer', 'transferred')
        ->get();

        foreach ($items as $item) {
            $user = User::where('id', $item->sell_user)->first();
            $item->user_id = $user->id;
            $item->nickname = $user->nickname;

            if ($item->transfer == 'applied') {
                $item->status_name = '振込申請済み';
            } elseif ($item->transfer == 'unapplied') {
                $item->status_name = '未申請';
            } elseif ($item->transfer == 'transferred') {
                $item->status_name = '振込済み';
            }

            $item->transfer_price = $item->price * 0.9 - $item->cancel_fee;
            if ($item->transfer_price < 0) {
                $item->transfer_price = 0;
            }
        }
        return view('admin.transfer.done_list', compact('items'));
    }

    public function adminTransferDetail($user_id){

        $user = User::where('id', $user_id)->first();
    
        $items = Payment::where('sell_user', $user_id)
        ->where('transfer', 'applied')
        ->get();

        $total_transfer_price = 0;
        foreach($items as $item){
            $item->transfer_price = $item->price * 0.9 - $item->cancel_fee;
            if ($item->transfer_price < 0) {
                $item->transfer_price = 0;
            }
            $total_transfer_price += $item->transfer_price;

            if ($item->transfer == 'applied') {
                $item->status_name = '振込申請済み';
            } elseif ($item->transfer == 'unapplied') {
                $item->status_name = '未申請';
            } elseif ($item->transfer == 'transferred') {
                $item->status_name = '振込済み';
            }
        }

        $bank = BankAccount::where('user_id', $user_id)->first();
    
        return view('admin.transfer.detail', compact('items', 'total_transfer_price', 'user', 'bank'));
    }

    public function adminTransferDone(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();

        $items = Payment::where('sell_user', $user_id)
        ->where('transfer', 'applied')
        ->get();
        foreach ($items as $item){
            $item->transfer = 'transferred';
            $item->save();
        }

        //ユーザーへの通知
        $announcement_user = new Announcement([
            'title' =>  '振込が完了しました。',
            'description' =>  '正常に振り込まれているかご確認ください。',
            'link' => 'proceeds.information',
        ]);
        $announcement_user->save();

        $announcementRead_user = new AnnouncementRead([
            'user_id' => $user_id,
            'announcement_id' => $announcement_user->id,
            'read' => false
        ]);
        $announcementRead_user->save();
        
        return redirect()->back();
    }

}
