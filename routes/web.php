<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotaruRequestController;
use App\Http\Controllers\UserProfileController;
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
    return view('welcome');
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
        Route::post('/request/session', 'sessionSave')->name('request.session.save');
        Route::get('/request/ohakamairi/confirm', 'ohakamairiConfirm')->name('ohakamairi.confirm');
        Route::get('/request/omamori/confirm', 'omamoriConfirm')->name('omamori.confirm');
        Route::get('/request/sanpai/confirm', 'sanpaiConfirm')->name('sanpai.confirm');
        Route::get('/request/others/confirm', 'othersConfirm')->name('others.confirm');

        //依頼完了
        Route::post('/request/done', 'done')->name('request.done');


        Route::get('/search','getSearch')->name('search.index');
        Route::get('/search/{request_id}','moreSearch')->name('search.more');
        Route::post('/search/post', 'postSearch')->name('search.post');

       

        Route::get('/chat', 'getChat')->name('chat.index');


        //////////プランごとに依頼を作成する画面/////////////
        Route::get('/request/ohakamairi', 'getOhakamairi')->name('request.ohakamairi');
        Route::get('/request/omamori', 'getOmamori')->name('request.omamori');
        Route::get('/request/sanpai', 'getSanpai')->name('request.sanpai');
        Route::get('/request/others', 'getOthers')->name('request.others');

    });

Route::controller(UserProfileController::class)->group(
    function () {
        Route::get('/mypage', 'getMypage')->name('mypage.index');
        Route::get('/mypage/myprofile', 'getMyProfile')->name('myprofile.index');
        Route::get('/mypage/myprofile/edit', 'editMyProfile')->name('myprofile.edit');
        Route::post('/mypage/myprofile/update', 'updateMyProfile')->name('myprofile.update');
        Route::post('/mypage/myprofile/image_update', 'updateImage')->name('myprofile.image.update');

        Route::get('/mypage/request', 'getMyRequest')->name('mypage.request');
        Route::get('/mypage/apply', 'getMyApply')->name('mypage.apply');

    });


require __DIR__.'/auth.php';


