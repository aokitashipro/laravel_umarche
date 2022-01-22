<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // 管理画面用のクッキー
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }
        // 管理画面用のクッキー
        if (request()->is('owner*')) {
            config(['session.cookie' => config('session.cookie_owner')]);
        }
    }
}
