<?php

namespace App\Providers;

use App\Http\Middleware\VoidGuard;
use Illuminate\Support\ServiceProvider;
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
        Auth::extend('no-database', function ($app, $name, array $config) {
            return new VoidGuard();
        });
    }
}
