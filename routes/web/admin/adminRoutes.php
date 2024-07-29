<?php

use App\Http\Middleware\Admin;
use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Back\DroitsController;
use App\Http\Controllers\Back\ParametreController;
use App\Http\Controllers\Back\ProfilController;
use App\Http\Controllers\Back\EvenementController;

// Admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware([Admin::class])->group(function () {
        
        Route::prefix('administration')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('admin');

          
            
            // Route::get('/calendrier', [EvenementController::class, 'index'])->name('vue.calendrier');
            // Route::post('/creer/un/evenement', [EvenementController::class, 'creerUnEvenement'])->name('creer.un.evenement');
            
            Route::resource('evenements', EvenementController::class)->only([
                'index', 'store', 'show', 'update', 'delete' 
            ]);

            Route::get('rafrachir/evenement', [EvenementController::class, 'rafrachirEvenement'])->name('refresh-events');
        });

    });
});
