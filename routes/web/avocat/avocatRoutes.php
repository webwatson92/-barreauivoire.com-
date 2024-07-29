<?php 
use App\Http\Controllers\Back\{AvocatController};
use App\Http\Middleware\Avocat;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Middleware\TwoFactor;

//Avocat
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware([Avocat::class])->group(function () {
        Route::middleware([TwoFactor::class])->group(function () {
            Route::prefix('avocat')->group(function () {
                Route::get('/', [AvocatController::class, 'index'])->name('avocat');
            });
        });
    
    });
});