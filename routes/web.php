<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


Route::controller(ServiceController::class)->group(function () {
    Route::get('/provider', 'providerIndex')->name('provider.index')->middleware('auth');
    Route::get('/seeker', 'seekerIndex')->name('seeker.index')->middleware('auth');
    Route::get('/', 'toppage')->name('toppage');
    Route::get('/request', 'getRequest')->name('request.index');

    //サービスを探す
    Route::get('/service', 'service')->name('service');
    Route::get('/service/search', 'searchService')->name('service.search');
    Route::get('/service/user/{user_id}', 'showUser')->name('service.show.user')->middleware('auth');
    Route::get('/service/detail/{service_id}', 'showDetail')->name('service.detail')->middleware('auth');


    Route::get('/service/create', 'create')->name('service.create')->middleware('auth');
    Route::post('/service/create/done', 'ServiceDone')->name('service.create.done')->middleware('auth');
    Route::post('/public_request/create/done', 'PubreqDone')->name('pubreq.create.done')->middleware('auth');
    Route::post('/service/destroy', 'destroy')->name('service.destroy')->middleware('auth');
    Route::get('/mypage/service/list', 'getMyServiceList')->name('mypage.service.list')->middleware('auth');
    Route::get('/mypage/pubreq_request/list', 'getMyPubreqList')->name('mypage.pubreq.list')->middleware('auth');
    Route::get('/mypage/service/edit/{service_id}', 'getMyServiceEdit')->name('mypage.service.edit')->middleware('auth');
    Route::post('/mypage/service/update', 'updateMyService')->name('mypage.service.update')->middleware('auth');

    //公開依頼の検索について
    Route::get('/public_request', 'getPubReq')->name('pubreq.index');
    Route::get('/public_request/search', 'searchPubReq')->name('pubreq.search');
    Route::get('/public_request/search/{service_id}', 'moreSearch')->name('pubreq.detail')->middleware('auth');
    Route::get('/public_request/create', 'requestCreate')->name('pubreq.create')->middleware('auth');
    Route::get('/public_request/edit/{service_id}', 'editPubreq')->name('pubreq.edit')->middleware('auth');
    Route::post('/public_request/update', 'update')->name('pubreq.update')->middleware('auth');
});

Route::controller(UserController::class)->group(
    function () {
        Route::get('/mypage', 'getMypage')->name('mypage.index');
        Route::get('/mypage/favorite_follow', 'FavoriteFollow')->name('mypage.favorite.follow');
        Route::get('/mypage/myprofile', 'getMyProfile')->name('myprofile.index')->middleware('auth');
        Route::get('/mypage/myprofile/edit', 'editMyProfile')->name('myprofile.edit')->middleware('auth');
        Route::post('/mypage/myprofile/update', 'updateMyProfile')->name('myprofile.update')->middleware('auth');
        Route::post('/mypage/myprofile/image_update', 'updateImage')->name('myprofile.image.update')->middleware('auth');

        Route::get('/mypage/request', 'getMyRequest')->name('mypage.myrequest.index')->middleware('auth');
        Route::get('/mypage/myrequest/detail/{service_id}', 'getMyRequestDetail')->name('mypage.myrequest.detail')->middleware('auth');

        Route::get('/user/profile/{user_id}', 'getUserProfile')->name('user.profile')->middleware('auth');

        Route::get('/user/detail/{user_id}', 'getUserDetail')->name('user.detail')->middleware('auth');

        Route::post('/user/identification_photo/send', 'sendIdentificationPhoto')->name('send.identification');
    }
);

Route::controller(ChatController::class)->group(
    function () {
        Route::get('/chat/list_buy', 'getChatList')->name('chat.list')->middleware('auth');
        Route::get('/chat/list_sell', 'getChatSellList')->name('chat.list.sell')->middleware('auth');

        Route::get('/chat/room/{room_id}', 'getChatRoom')->name('chat.room')->middleware('auth');
        Route::post('/chat/send', 'sendChat')->name('send.chat')->middleware('auth');
        Route::post('/chat/delivery/offer', 'offerDelivery')->name('offer.delivery')->middleware('auth');
    }
);

Route::controller(FavoriteController::class)->group(function () {
    Route::post('/service/{service_id}/favorite', 'favorite')->name('favorite');
    Route::post('/service/{service_id}/unfavorite', 'unfavorite')->name('unfavorite');
});

Route::controller(FollowController::class)->group(function () {
    Route::post('/service/{follower_id}/follow', 'follow')->name('follow');
    Route::post('/service/{follower_id}/unfollow', 'unfollow')->name('unfollow');
});

Route::controller(EntryController::class)->group(function () {
    Route::post('/search/offer/post', 'sendOffer')->name('service.offer.send')->middleware('auth');
    Route::post('/public_request/estimate', 'postEstimate')->name('pubreq.estimate')->middleware('auth');
    Route::get('/public_request/entried_users/{service_id}', 'pubreqEntried')->name('pubreq.entried');
    Route::post('/public_request/entried_users/approve', 'pubreqApprove')->name('pubreq.approve');
    Route::post('/public_request/entried_users/unapprove', 'pubreqUnapprove')->name('pubreq.unapprove');

    ////出品サービス側//////////
    Route::post('/service/consult/send', 'serviceConsult')->name('service.consult')->middleware('auth');
    Route::post('/service/estimate/send', 'serviceEstimate')->name('service.estimate')->middleware('auth');
    Route::get('/service/entried/users/{service_id}', 'serviceEntried')->name('service.entried')->middleware('auth');
    Route::post('/service/entried_users/approve', 'serviceApprove')->name('service.approve');
    Route::post('/service/entried_users/unapprove', 'serviceUnapprove')->name('service.unapprove');
});

//見積書関連
Route::controller(AgreementController::class)->group(function () {
    Route::get('/agreement/create/{service_id}/{entry_id}', 'create')->name('agreement.create')->middleware('auth');
    Route::post('/agreement/create/done', 'done')->name('agreement.create.done')->middleware('auth');
    Route::get('/agreement/index/{agreement_id}', 'index')->name('agreement.index');
    Route::get('/agreement/edit/{agreement_id}', 'edit')->name('agreement.edit');
    Route::post('/agreement/update', 'update')->name('agreement.update')->middleware('auth');
    Route::post('/agreement/cancel', 'cancel')->name('agreement.cancel')->middleware('auth');

    //購入者側が見積もりに対する行動
    Route::post('/agreement/unapporoved', 'unapproved')->name('agreement.unapproved')->middleware('auth');
    Route::get('/payment/{agreement_id}', 'payment')->name('payment')->middleware('auth');
    Route::get('/payment/success/{agreement_id}', 'successPayment')->name('payment.success')->middleware('auth');
    Route::get('/payment/cancel/offer/{entry_id}/{agreement_id}', 'buyerCancel')->name('buyer.cancel.offer')->middleware('auth');
    //出品者からのキャンセル
    Route::get('/proceeds/cancel/offer/{entry_id}/{agreement_id}', 'sellerCancel')->name('seller.cancel.offer')->middleware('auth');
    //購入者キャンセルオファー送信
    Route::post('/cancel/buyer/offer/done', 'cancelBuyerOffer')->name('cancel.offer.buyer')->middleware('auth');
    Route::post('/cancel/seller/offer/done', 'cancelSellerOffer')->name('cancel.offer.seller')->middleware('auth');
});


Route::controller(AnnouncementController::class)->group(function () {
    Route::get('/announcement', 'index')->name('announcement.index')->middleware('auth');

    Route::post('/announcement-read', 'read')->name('announcement.read');


    //管理画面用
    Route::get('/admin-limited/announcement', 'adminIndex')->name('admin.announcement.index');

    Route::post('/admin-limited/announcement-read', 'adminRead')->name('admin.announcement.read');
});

Route::controller(PaymentController::class)->group(
    function () {
        Route::get('/mypage/payment/index', 'paidInformation')->name('payment.information')->middleware('auth');
        Route::get('/mypage/proceeds/index', 'proceedsInformation')->name('proceeds.information')->middleware('auth');
    });

//管理者
Route::controller(AdminController::class)->group(function (){
        //ユーザー管理
        Route::get('/admin-limited', 'index')->name('admin.index');
        Route::get('/admin-limited/user/list', 'userList')->name('admin.user.list');
        Route::get('admin-limited/user/detail/{user_id}', 'userDetail')->name('admin.user.detail');
        Route::get('admin-limited/user/edit/{user_id}', 'userEdit')->name('admin.user.edit');
        Route::post('/admin-limited/user/update', 'userUpdate')->name('admin.user.update');

        //サービス管理
        Route::get('/admin-limited/service/list', 'serviceList')->name('admin.service.list');
        Route::get('/admin-limited/service/detail/{service_id}', 'serviceDetail')->name('admin.service.detail');
        Route::get('/admin-limited/service/edit/{service_id}', 'serviceEdit')->name('admin.service.edit');
        Route::post('/admin-limited/service/update', 'serviceUpdate')->name('admin.service.update');

        //ユーザー同士のチャットの監視
        Route::get('/admin-limited/user_chat/list', 'userChatList')->name('admin.user.chat.list');
        Route::get('/admin-limited/user_chat/room/{room_id}', 'userChatRoom')->name('admin.user.chat.room');
        Route::post('/admin-limited/user_chat/send', 'postUserChat')->name('admin.user.chat.send');
        Route::post('/admin-limited/user_chat/stop', 'stopUserChat')->name('admin.user.chat.stop');
        Route::post('/admin-limited/user_chat/unstop', 'unstopUserChat')->name('admin.user.chat.unstop');
        //キャンセル
        Route::get('/admin-limited/cancel_offer/list', 'cancelOfferList')->name('admin.cancel.offer.list');
        Route::get('/admin-limited/cancel_offer/detail/{cancel_id}', 'cancelOfferDetail')->name('admin.cancel.offer.detail');
        Route::post('/admin-limited/cancel/approve', 'approveCancel')->name('admin.cancel.approved');
        Route::post('/admin-limited/cancel/unapprove', 'unapproveCancel')->name('admin.cancel.unapproved');
        //本人確認証明
        Route::get('/admin-limited/identification/offer/list', 'identificationOfferList')->name('admin.identification.offer.list');
        Route::get('admin-limited/identification/detail/{identification_id}', 'identificationDetail')->name(
        'admin.identification.detail');
        Route::get('/admin-limited/identification/approved/list', 'identificationApprovedList')->name('admin.identification.approved.list');
        Route::get('/admin-limited/identification/unapproved/list', 'identificationUnapprovedList')->name('admin.identification.unapproved.list');
        Route::post('/admin-limited/identification/approved', 'identificationApproved')->name('admin.identification.approved');
        Route::post('/admin-limited/identification/unapproved', 'identificationUnapproved')->name('admin.identification.unapproved');


    });




require __DIR__ . '/auth.php';
