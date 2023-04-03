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

class EntryController extends Controller
{
    public function sendOffer(Request $request)
    {
        $entry = new Entry();
        $sell_user = Auth::id();
        $buy_user = $request->buy_user;
        $service_id = $request->service_id;

        $entry->service_id = $service_id;
        $entry->buy_user = $buy_user;
        $entry->sell_user = $sell_user;
        $entry->status = 'pending';
        $entry->save();

        //チャットルームが存在するか確認
        $room = ChatRoom::where('service_id', $service_id)->where('buy_user', $buy_user)->where('sell_user', $sell_user)->first();
        if($room === null){
            $room = new ChatRoom();
            $room->service_id = $service_id;
            $room->buy_user = $buy_user;
            $room->sell_user = $sell_user;
            $room->save();
        }
        //Chatモデルへ反映させる
        $room = ChatRoom::where('service_id', $service_id)->where('buy_user', $buy_user)->where('sell_user', $sell_user)->first();
        $chat = new Chat();
        $chat->room_id = $room->id;
        $chat->sender_id = $sell_user;
        $chat->receiver_id = $buy_user;
        $chat->message = $request->first_chat;
        $chat->save();

        return redirect()->route('chat.list');
    }
}
