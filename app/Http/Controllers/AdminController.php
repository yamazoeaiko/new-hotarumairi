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

        $cancel->refund = 'will_refund';
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
}
