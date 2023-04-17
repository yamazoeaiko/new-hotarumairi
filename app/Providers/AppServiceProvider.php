<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ユーザーがログインしている場合にのみ、ビューコンポーザーを実行
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('announcements', Announcement::whereHas('reads', function ($query) use ($user) {

                    $query->where('user_id', $user->id)
                        ->where('read', false);
                })->get());
            }
        });
    }
}
