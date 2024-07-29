<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Middleware\Admin;
use App\Http\Middleware\TwoFactor;
use App\Http\Controllers\Back\{ProfilController};
use App\Http\Controllers\Auth\TwoFactorController;

Route::middleware(['auth'])->group(function() {

    Route::middleware([Admin::class])->group(function () {

        

    });

});