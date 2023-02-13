<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotaruRequestController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AnnouncementController;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


Route::controller(HotaruRequestController::class)->group(
    function () {
        Route::get('/request','getRequest')->name('request.index');
        Route::post('/request/session', 'sessionSave')->name('request.session.save')->middleware('auth');
        Route::get('/request/ohakamairi/confirm', 'ohakamairiConfirm')->name('ohakamairi.confirm')->middleware('auth');
        Route::get('/request/omamori/confirm', 'omamoriConfirm')->name('omamori.confirm')->middleware('auth');
        Route::get('/request/sanpai/confirm', 'sanpaiConfirm')->name('sanpai.confirm')->middleware('auth');
        Route::get('/request/others/confirm', 'othersConfirm')->name('others.confirm')->middleware('auth');

        //依頼完了
        Route::post('/request/done', 'done')->name('request.done');


        Route::get('/search','getSearch')->name('search.index');
        Route::get('/search/{request_id}','moreSearch')->name('search.more')->middleware('auth');
        Route::post('/search/post', 'postSearch')->name('search.post');


        Route::get('/chat', 'getChat')->name('chat.index')->middleware('auth');


        //////////プランごとに依頼を作成する画面/////////////
        Route::get('/request/ohakamairi', 'getOhakamairi')->name('request.ohakamairi')->middleware('auth');
        Route::get('/request/omamori', 'getOmamori')->name('request.omamori')->middleware('auth');
        Route::get('/request/sanpai', 'getSanpai')->name('request.sanpai')->middleware('auth');
        Route::get('/request/others', 'getOthers')->name('request.others')->middleware('auth');
        Route::post('/search/apply', 'searchApply')->name('search.apply')->middleware('auth');

    });

Route::controller(UserProfileController::class)->group(
    function () {
        Route::get('/mypage', 'getMypage')->name('mypage.index');
        Route::get('/mypage/myprofile', 'getMyProfile')->name('myprofile.index')->middleware('auth');
        Route::get('/mypage/myprofile/edit', 'editMyProfile')->name('myprofile.edit')->middleware('auth');
        Route::post('/mypage/myprofile/update', 'updateMyProfile')->name('myprofile.update')->middleware('auth');
        Route::post('/mypage/myprofile/image_update', 'updateImage')->name('myprofile.image.update')->middleware('auth');

        Route::get('/mypage/request', 'getMyRequest')->name('mypage.myrequest.index')->middleware('auth');
        Route::get('/mypage/myrequest/detail/{request_id}', 'getMyRequestDetail')->name('mypage.myrequest.detail')->middleware('auth');
        Route::get('/mypage/myrequest/edit/{request_id}', 'editMyRequest')->name('mypage.myrequest.edit')->middleware('auth');
        Route::get('/mypage/myrequest/destroy/{request_id}', 'destroyMyRequest')->name('mypage.myrequest.destroy')->middleware('auth');
        Route::get('/mypage/myrequest/member_list/{request_id}', 'getApplyMemberList')->name('mypage.myrequest.member_list')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/{request_id}/{user_id}/{apply_id}', 'getApplyMemberDetail')->name('mypage.myrequest.member_detail')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/approval/{apply_id}/{request_id}/{user_id}', 'getApplyApproval')->name('myrequest.member.approval')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/reject/{apply_id}/{request_id}/{user_id}', 'getApplyReject')->name('myrequest.member.reject')->middleware('auth');


        Route::get('/mypage/myapply', 'getMyApply')->name('mypage.myapply.index')->middleware('auth');
        Route::get('/mypage/myapply/detail/{request_id}', 'getMyApplyDetail')->name('mypage.myapply.detail')->middleware('auth');

        //支払い関連
        Route::get('/mypage/myrequest/paid/{request_id}/{user_id}/{apply_id}', 'paid')->name('mypage.myrequest.paid');

    });

Route::controller(ChatController::class)->group(
    function (){
        Route::get('/chat/list','getChatList')->name('chat.list')->middleware('auth');
        Route::get('/chat/room/{apply_id}/{your_id}', 'getChatRoom')->name('chat.room')->middleware('auth');
        Route::post('/chat/send', 'sendChat')->name('send.chat')->middleware('auth');

    });

Route::controller(AnnouncementController::class)->group(function(){
    Route::get('/announcement','index')->name('announcement.index');
    Route::get('/announcement/list', 'list')->name('announcement.list');
    Route::get('/announcement/show', 'show')->name('announcement.show');
});
require __DIR__.'/auth.php';