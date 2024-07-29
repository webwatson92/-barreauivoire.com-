<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\EnsureTokenIsValid;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
        //     // \Illuminate\Http\Middleware\TrustHosts::class,
        ]);

        $middleware->alias([
            'superadmin' => App\Middleware\SuperAdmin::class,
            'admin' => App\Middleware\Admin::class,
            'twoFactor' => App\Middleware\TwoFactor::class,
            'barreau' => App\Middleware\Barreau::class,
            'avocat' => App\Middleware\Avocat::class,
            // 'user' => App\Middleware\User::class,
            // 'auth' => Illuminate\Auth\Middleware\Authenticate::class
            
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    
    ->create();
