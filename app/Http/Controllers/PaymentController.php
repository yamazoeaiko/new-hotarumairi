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
use App\Models\BankAccount;

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
        $before_transfer_proceeds = 0;
        $applied_transfer_proceeds = 0;

        foreach ($proceeds as $proceed) {
            $buyer = User::where('id', $proceed->buy_user)->first();
            $proceed->buyer_name = $buyer->nickname;

            $service = Service::where('id', $proceed->service_id)->first();
            $proceed->service_name = $service->main_title;
            $proceed->price_net = $proceed->price * 0.9;

            if ($proceed->cancel_fee == null) {
                $total_proceeds += $proceed->price * 0.9;
                $proceed->cancel_fee = 0;
            } else {
                if ($proceed->price * 0.9 - $proceed->cancel_fee < 0) {
                    $proceed->price_net = 0;
                    $total_proceeds += 0;
                } else {
                    $proceed->price_net = $proceed->price * 0.9 - $proceed->cancel_fee;
                    $total_proceeds += $proceed->price * 0.9 - $proceed->cancel_fee;
                }
            }

            if ($proceed->transfer == 'unapplied') {
                $proceed->transfer_status = '未申請';
                $before_transfer_proceeds += $proceed->price * 0.9 - $proceed->cancel_fee;
            } elseif ($proceed->transfer == 'applied') {
                $proceed->transfer_status = '申請済み';
                $applied_transfer_proceeds += $proceed->price * 0.9 - $proceed->cancel_fee;
            } else {
                $proceed->transfer_status = '振込済み';
            }
        }

        return view('mypage.proceeds.index', compact('proceeds', 'total_proceeds', 'before_transfer_proceeds', 'applied_transfer_proceeds', 'user_id'));
    }

    //口座情報関連
    public function bankInformation(){
        $user_id = Auth::id();
        $item = BankAccount::where('user_id', $user_id)->first();

        return view('mypage.bank.index', compact('item'));
    }

    public function bankCreate(){
        $user_id = Auth::id();

        return view('mypage.bank.create', compact('user_id'));
    }

    public function bankDone(Request $request){
        $bank_account = new BankAccount();
        $bank_account->user_id = $request->user_id;
        $bank_account->bank_name = $request->bank_name;
        $bank_account->branch_name = $request->branch_name;
        $bank_account->account_type = $request->account_type;
        $bank_account->account_number = $request->account_number;
        $bank_account->account_name = $request->account_name;
        $bank_account->save();

        $item = BankAccount::where('user_id', $request->user_id)->first();

        return redirect()->route('mypage.bank.index',compact('item'));
    }

    public function bankEdit(){
        $user_id = Auth::id();
        $item = BankAccount::where('user_id', $user_id)->first();

        return view('mypage.bank.edit', compact('item', 'user_id'));
    }

    public function bankUpdate(Request $request){
        $bank_account = BankAccount::where('user_id', $request->user_id)->first();
        $bank_account->user_id = $request->user_id;
        $bank_account->bank_name = $request->bank_name;
        $bank_account->branch_name = $request->branch_name;
        $bank_account->account_type = $request->account_type;
        $bank_account->account_number = $request->account_number;
        $bank_account->account_name = $request->account_name;
        $bank_account->save();

        $item = BankAccount::where('user_id', $request->user_id)->first();

        return redirect()->route('mypage.bank.index', compact('item'));
    }

    public function offerTransfer(Request $request){
        $user_id = $request->user_id;
        $user = User::where('id', $user_id)->first();
        $items = Payment::where('sell_user', $user_id)->get();
        foreach($items as $item){
            $item->transfer = 'applied';
            $item->save();
        }

        //userへのメッセージ
        $announcement_user = new Announcement([
            'title' =>  '振込申請をしました。',
            'description' =>  '管理者が確認中です',
            'link' => 'proceeds.information',
        ]);
        $announcement_user->save();

        $announcementRead_user = new AnnouncementRead([
            'user_id' => $user_id,
            'announcement_id' => $announcement_user->id,
            'read' => false
        ]);
        $announcementRead_user->save();

        //管理者へのメッセージ
        $announcement_admin = new Announcement([
            'title' =>  $user->nickname . 'から振込申請があります。',
            'description' =>  '振込を実行してください',
            'link' => 'admin.transfer.offer_list',
        ]);
        $announcement_admin->save();

        $announcementRead_admin = new AnnouncementRead([
            'user_id' => 1,
            'announcement_id' => $announcement_admin->id,
            'read' => false
        ]);
        $announcementRead_admin->save();

        return redirect()->back();
    }

}
