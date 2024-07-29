


<?php
use App\Http\Controllers\Back\ModelActeController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/model-actes', [ModelActeController::class, 'index'])->name('model-acte.index');
    Route::get('/chargerdocumentmodelacte', [ModelActeController::class, 'chargerListeDeModelActe'])->name('charger.liste.modelacte');
    // Route en Post pour Ajouter un modèle acte dans la base de données
    Route::post('/model-actes/create', [ModelActeController::class, 'create'])->name('model-acte.create');
    Route::delete('/model-actes/delete/{id}', [ModelActeController::class, 'delete'])->name('model-acte.delete');
    Route::get('/model-actes/{id}', [ModelActeController::class, 'show'])->name('model-acte.show');
});


