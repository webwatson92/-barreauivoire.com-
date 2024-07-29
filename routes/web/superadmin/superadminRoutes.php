<?php
use App\Http\Controllers\Back\{SuperAdminController, DroitsController};
use App\Http\Middleware\SuperAdmin;

//SuperAdmin
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::middleware([SuperAdmin::class])->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin');
    });
});