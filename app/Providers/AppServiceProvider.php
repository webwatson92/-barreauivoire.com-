<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        setlocale(LC_TIME, config('app.locale'));

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin' || auth()->user()->role === 'barreau';
        });

        Blade::if('user', function () {
            return auth()->check() && auth()->user()->role === 'user';
        });

        Blade::if('avocat', function () {
            return auth()->check() && auth()->user()->role === 'avocat';
        });

        Blade::if('adminbarreau', function () {
            return auth()->check() && auth()->user()->role === 'barreau' || auth()->user()->role === 'admin';
        });
        Blade::if('avocatuser', function () {
            return auth()->check() && auth()->user()->role === 'avocat' || auth()->user()->role === 'user';
        });
    }
}
