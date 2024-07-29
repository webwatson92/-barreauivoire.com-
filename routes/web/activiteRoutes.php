
<?php
use App\Http\Controllers\Back\ActiviteController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/activites', [ActiviteController::class, 'index'])->name('activite.index');

    Route::get('/chargerdocumentactivite', [ActiviteController::class, 'chargerListeActivite'])->name('charger.liste.activite');
    // Route en Post/Delete/Get pour Ajouter une activité dans la base de données
    Route::post('/activites/create', [ActiviteController::class, 'create'])->name('activite.create');
    Route::delete('/activites/delete/{id}', [ActiviteController::class, 'delete'])->name('activite.delete');
    Route::get('/activites/{id}', [ActiviteController::class, 'show'])->name('activite.show');
    Route::put('/activites/{id}', [ActiviteController::class, 'update'])->name('activite.update');

});