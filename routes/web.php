<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotaruRequestController;
use App\Http\Controllers\UserProfileController;
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


Route::controller(HotaruRequestController::class)->group(
    function () {
        Route::get('/','toppage')->name('toppage');
        Route::get('/request','getRequest')->name('request.index');
        Route::post('/request/session', 'sessionSave')->name('request.session.save')->middleware('auth');
        Route::get('/request/ohakamairi/confirm', 'ohakamairiConfirm')->name('ohakamairi.confirm')->middleware('auth');
        Route::get('/request/omamori/confirm', 'omamoriConfirm')->name('omamori.confirm')->middleware('auth');
        Route::get('/request/sanpai/confirm', 'sanpaiConfirm')->name('sanpai.confirm')->middleware('auth');
        Route::get('/request/others/confirm', 'othersConfirm')->name('others.confirm')->middleware('auth');

        //????????????
        Route::post('/request/done', 'done')->name('request.done');


        Route::get('/search','getSearch')->name('search.index');
        Route::get('/search/{request_id}','moreSearch')->name('search.more')->middleware('auth');
        Route::post('/search/post', 'postSearch')->name('search.post');


        Route::get('/chat', 'getChat')->name('chat.index')->middleware('auth');


        //////////?????????????????????????????????????????????/////////////
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

        //myrequest?????????
        //ohakamairi
        Route::get('/mypage/myrequest/edit/ohakamairi/{request_id}', 'editOhakamairi')->name('mypage.myrequest.edit.ohakamairi')->middleware('auth');
        //omamori
        Route::get('/mypage/myrequest/edit/omamori/{request_id}', 'editOmamori')->name('mypage.myrequest.edit.omamori')->middleware('auth');

        //sanpai
        Route::get('/mypage/myrequest/edit/sanpai/{request_id}', 'editSanpai')->name('mypage.myrequest.edit.sanpai')->middleware('auth');

        //others
        Route::get('/mypage/myrequest/edit/others/{request_id}', 'editOthers')->name('mypage.myrequest.edit.others')->middleware('auth');

        //???????????????
        Route::post('/mypage/myrequest/update/ohakamairi/{request_id}', 'updateOhakamairi')->name('myrequest.update.ohakamairi');

        Route::post('/mypage/myrequest/update/omamori/{request_id}', 'updateOmamori')->name('myrequest.update.omamori');

        Route::post('/mypage/myrequest/update/sanpaii/{request_id}', 'updateSanpai')->name('myrequest.update.sanpai');

        Route::post('/mypage/myrequest/update/others/{request_id}', 'updateOthers')->name('myrequest.update.others');



        Route::get('/mypage/myrequest/destroy/{request_id}', 'destroyMyRequest')->name('mypage.myrequest.destroy')->middleware('auth');
        Route::get('/mypage/myrequest/member_list/{request_id}', 'getApplyMemberList')->name('mypage.myrequest.member_list')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/{request_id}/{user_id}/{apply_id}', 'getApplyMemberDetail')->name('mypage.myrequest.member_detail')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/approval/{apply_id}/{request_id}/{user_id}', 'getApplyApproval')->name('myrequest.member.approval')->middleware('auth');
        Route::get('/mypage/myrequest/member_detail/reject/{apply_id}/{request_id}/{user_id}', 'getApplyReject')->name('myrequest.member.reject')->middleware('auth');


        Route::get('/mypage/myapply', 'getMyApply')->name('mypage.myapply.index')->middleware('auth');
        Route::get('/mypage/myapply/detail/{request_id}', 'getMyApplyDetail')->name('mypage.myapply.detail')->middleware('auth');

        //???????????????
        Route::get('/mypage/myrequest/paid/{request_id}/{user_id}/{apply_id}', 'paid')->name('mypage.myrequest.paid');

    });

Route::controller(ChatController::class)->group(
    function (){
        Route::get('/chat/list','getChatList')->name('chat.list')->middleware('auth');
        Route::get('/chat/room/{room_id}/{theother_id}', 'getChatRoom')->name('chat.room')->middleware('auth');
        Route::post('/chat/send', 'sendChat')->name('send.chat')->middleware('auth');
        Route::get('/chat/service/room', 'serviceRoom')->name('chat.service.room');
    });

Route::controller(AnnouncementController::class)->group(function(){
    Route::get('/announcement','index')->name('announcement.index');
    Route::get('/announcement/list', 'list')->name('announcement.list');
    Route::get('/announcement/show', 'show')->name('announcement.show');
});

Route::controller(ServiceController::class)->group(function(){
    Route::get('/service/search','search')->name('service.search');
    Route::get('/service/user/{user_id}','showUser')->name('service.show.user');
    Route::get('/service/detail/{service_id}', 'showDetail')->name('service.detail');
    Route::get('/service/create','create')->name('service.create');
    Route::post('/service/create/done','done')->name('service.create.done');
    Route::get('/service/{service_id}/edit','edit')->name('service.edit');
    Route::post('/service/update','update')->name('service.update');
    Route::post('/service/destroy', 'destroy')->name('service.destroy');
    Route::get('/mypage/service/list','getMyServiceList')->name('mypage.service.list');
    Route::get('/mypage/service/edit/{service_id}', 'getMyServiceEdit')->name('mypage.service.edit');
    Route::post('/mypage/service/update', 'updateMyService')->name('mypage.service.update');

    //??????????????????????????????????????????????????????????????????????????????????????????
    Route::post('/service/consult/send','sendConsult')->name('service.consult.send');
    Route::get('/service/fixed/{fix_id}', 'getFixed')->name('service.fixed');
    Route::get('/service/fixed/edit/{fix_id}', 'getFixedEdit')->name('service.fixed.edit');
    Route::post('/service/fixed/update','updateFixed')->name('service.fixed.update');
    Route::post('/service/estimate/post', 'postEstimate')->name('service.estimate.post');
    Route::post('/service/estimate/approve', 'approveEstimate')->name('service.estimate.approve');
    Route::get('/service/paid/success/{fix_id}', 'paidSuccess')->name('service.paid.success');
    Route::post('/searvice/search/post', 'searchPost')->name('service.search.post');
});

Route::controller(FavoriteController::class)->group(function () {
    Route::post('/service/{service_id}/favorite', 'favorite')->name('favorite');
    Route::post('/service/{service_id}/unfavorite', 'unfavorite')->name('unfavorite');
});

Route::controller(FollowController::class)->group(function () {
    Route::post('/service/{follower_id}/follow', 'follow')->name('follow');
    Route::post('/service/{follower_id}/unfollow', 'unfollow')->name('unfollow');
});
require __DIR__.'/auth.php';