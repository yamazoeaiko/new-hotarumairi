<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\ChatRoom;
use App\Models\Entry;
use App\Models\Service;
use App\Models\Agreement;
use App\Models\Payment;
use Stripe\Stripe;
use Illuminate\Support\Str;
use App\Models\Announcement;
use App\Models\AnnouncementRead;

class PaymentController extends Controller
{
    //ユーザー支払い情報
    public function paidInformation()
    {
        $user_id = Auth::id();

        $payments = Payment::where('buy_user', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $total_payments = 0;
        foreach ($payments as $payment) {
            $provider = User::where('id', $payment->sell_user)->first();
            $payment->provider_name = $provider->nickname;

            $service = Service::where('id', $payment->service_id)->first();
            $payment->service_name = $service->main_title;

            if ($payment->cancel_fee == null) {
                $total_payments += $payment->include_tax_price;
                $payment->cancel_fee = 0;
            } else {
                $total_payments += $payment->include_tax_price - $payment->cancel_fee;
            }
        }

        return view('mypage.payment.index', compact('payments', 'total_payments'));
    }

    //ユーザーの売上情報
    public function proceedsInformation()
    {
        $user_id = Auth::id();

        $proceeds = Payment::where('sell_user', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $total_proceeds = 0;
        foreach ($proceeds as $proceed) {
            $buyer = User::where('id', $proceed->buy_user)->first();
            $proceed->buyer_name = $buyer->nickname;

            $service = Service::where('id', $proceed->service_id)->first();
            $proceed->service_name = $service->main_title;
            $proceed->price_net = $proceed->price*0.9;

            if ($proceed->cancel_fee == null) {
                $total_proceeds += $proceed->price*0.9;
                $proceed->cancel_fee = 0;
            } else {
                if ($proceed->price * 0.9 - $proceed->cancel_fee < 0) {
                    $proceed->price_net = 0;
                    $total_proceeds += 0;
                }else {
                    $proceed->price_net = $proceed->price * 0.9 - $proceed->cancel_fee;
                $total_proceeds += $proceed->price*0.9 - $proceed->cancel_fee;
                }
            }
        }


        return view('mypage.proceeds.index', compact('proceeds', 'total_proceeds'));
    }
}
