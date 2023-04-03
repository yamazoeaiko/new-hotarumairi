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
    Route::get('/request/create', 'request')->name('service.request')->middleware('auth');
    Route::get('/service/search', 'search')->name('service.search');
    Route::get('/service/user/{user_id}', 'showUser')->name('service.show.user')->middleware('auth');
    Route::get('/service/detail/{service_id}', 'showDetail')->name('service.detail')->middleware('auth');
    Route::get('/service/create', 'create')->name('service.create')->middleware('auth');
    Route::post('/service/create/done', 'done')->name('service.create.done')->middleware('auth');
    Route::get('/service/{service_id}/edit', 'edit')->name('service.edit')->middleware('auth');
    Route::post('/service/update', 'update')->name('service.update')->middleware('auth');
    Route::post('/service/destroy', 'destroy')->name('service.destroy')->middleware('auth');
    Route::get('/mypage/service/list', 'getMyServiceList')->name('mypage.service.list')->middleware('auth');
    Route::get('/mypage/service/edit/{service_id}', 'getMyServiceEdit')->name('mypage.service.edit')->middleware('auth');
    Route::post('/mypage/service/update', 'updateMyService')->name('mypage.service.update')->middleware('auth');

    //公開依頼の検索について
    Route::get('/public_request', 'getPubReq')->name('pubreq.index');
    Route::get('/public_request/search', 'searchPubReq')->name('pubreq.search');
    Route::get('/search/{service_id}', 'moreSearch')->name('search.more')->middleware('auth');

    //ここからは、見積もり相談したりなどユーザー同士の連携について
    Route::post('/service/consult/send', 'sendConsult')->name('service.consult.send');
    Route::get('/service/fixed/{fix_id}', 'getFixed')->name('service.fixed');
    Route::get('/service/fixed/edit/{fix_id}', 'getFixedEdit')->name('service.fixed.edit');
    Route::post('/service/fixed/update', 'updateFixed')->name('service.fixed.update');
    Route::post('/service/estimate/post', 'postEstimate')->name('service.estimate.post');
    Route::post('/service/estimate/approve', 'approveEstimate')->name('service.estimate.approve');
    Route::get('/service/paid/success/{fix_id}', 'paidSuccess')->name('service.paid.success');
    Route::post('/searvice/search/post', 'searchPost')->name('service.search.post');
});

Route::controller(UserController::class)->group(
    function () {
        Route::get('/mypage', 'getMypage')->name('mypage.index');
        Route::get('/mypage/myprofile', 'getMyProfile')->name('myprofile.index')->middleware('auth');
        Route::get('/mypage/myprofile/edit', 'editMyProfile')->name('myprofile.edit')->middleware('auth');
        Route::post('/mypage/myprofile/update', 'updateMyProfile')->name('myprofile.update')->middleware('auth');
        Route::post('/mypage/myprofile/image_update', 'updateImage')->name('myprofile.image.update')->middleware('auth');

        Route::get('/mypage/request', 'getMyRequest')->name('mypage.myrequest.index')->middleware('auth');
        Route::get('/mypage/myrequest/detail/{service_id}', 'getMyRequestDetail')->name('mypage.myrequest.detail')->middleware('auth');



        Route::get('/mypage/myrequest/destroy/{service_id}', 'destroyMyRequest')->name('mypage.myrequest.destroy')->middleware('auth');
        Route::get('/mypage/myrequest/member_list/{service_id}', 'getApplyMemberList')->name('mypage.myrequest.member_list')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/{service_id}/{user_id}/{apply_id}', 'getApplyMemberDetail')->name('mypage.myrequest.member_detail')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/approval/{apply_id}/{service_id}/{user_id}', 'getApplyApproval')->name('myrequest.member.approval')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/reject/{apply_id}/{service_id}/{user_id}', 'getApplyReject')->name('myrequest.member.reject')->middleware('auth');


        Route::get('/mypage/myapply', 'getMyApply')->name('mypage.myapply.index')->middleware('auth');
        Route::get('/mypage/myapply/detail/{service_id}', 'getMyApplyDetail')->name('mypage.myapply.detail')->middleware('auth');

        //支払い関連
        Route::get('/mypage/myrequest/paid/{service_id}/{user_id}/{apply_id}', 'paid')->name('mypage.myrequest.paid');
    }
);

Route::controller(ChatController::class)->group(
    function () {
        Route::get('/chat/list', 'getChatList')->name('chat.list')->middleware('auth');
        Route::get('/chat/room/{room_id}', 'getChatRoom')->name('chat.room')->middleware('auth');
        Route::post('/chat/send', 'sendChat')->name('send.chat')->middleware('auth');
    }
);

Route::controller(AnnouncementController::class)->group(function () {
    Route::get('/announcement', 'index')->name('announcement.index');
    Route::get('/announcement/list', 'list')->name('announcement.list');
    Route::get('/announcement/show', 'show')->name('announcement.show');
});


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
});
require __DIR__ . '/auth.php';
