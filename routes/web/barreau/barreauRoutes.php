<?php 
use App\Http\Controllers\Back\{BarreauController};
use App\Http\Middleware\Barreau;
use App\Http\Controllers\Back\AdminController;

//Barreau
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware([Barreau::class])->group(function () {

        Route::prefix('barreau')->group(function () {
            Route::get('/', [BarreauController::class, 'index'])->name('barreau');

            
            Route::get('/liste/de/code/inscription', [BarreauController::class, 'vueListeDeCode'])->name('vue.listedecode');
            // Route::get('/listedecode', [ParametreController::class, 'ListeDeCode'])->name('listedecode');
            //chargement des codes barreau
            Route::get('/import/liste/code', [BarreauController::class, 'importerListeDeProfil'])->name('importer.listedeprofil');

        });
        
    
    });
});