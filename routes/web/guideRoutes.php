

<?php
use App\Http\Controllers\Back\GuideController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/guides', [GuideController::class, 'index'])->name('guide.index');
    Route::get('/chargerdocumentguide', [GuideController::class, 'chargerListeDeDocumentLu'])->name('charger.liste.guide');
    // Route en Post pour Ajouter un Guide dans la base de données
    Route::post('/guides/create', [GuideController::class, 'create'])->name('guide.create');
    Route::delete('/guides/{id}', [GuideController::class, 'delete'])->name('guide.delete');
    Route::get('/guides/{id}', [GuideController::class, 'show'])->name('guide.show');
});

