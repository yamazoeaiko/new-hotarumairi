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

    //サービスを探す
    Route::get('/service', 'service')->name('service');
    Route::get('/service/search', 'searchService')->name('service.search');
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

        Route::get('/user/profile/{user_id}', 'getUserProfile')->name('user.profile')->middleware('auth');
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
    Route::post('/public_request/estimate','postEstimate')->name('pubreq.estimate')->middleware('auth');
    Route::get('/public_request/entried_users/{service_id}', 'pubreqEntried')->name('pubreq.entried');
    Route::post('/public_request/entried_users/approve', 'pubreqApprove')->name('pubreq.approve');
    Route::post('/public_request/entried_users/unapprove', 'pubreqUnapprove')->name('pubreq.unapprove');
    Route::get('/payment/{entry_id}', 'payment')->name('payment')->middleware('auth');
    Route::get('/payment/success/{entry_id}', 'successPayment')->name('payment.success')->middleware('auth');
});
require __DIR__ . '/auth.php';
