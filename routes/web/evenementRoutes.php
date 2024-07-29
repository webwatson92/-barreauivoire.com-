<?php
use App\Http\Controllers\Back\EvenementController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenement.index');
    Route::get('/chargerdocumentevenement', [EvenementController::class, 'chargerListeEvenement'])->name('charger.liste.evenement');
    // Route en Post/Delete/Get pour Ajouter un evènement dans la base de données
    Route::post('/evenements/create', [EvenementController::class, 'create'])->name('evenement.create');
    Route::delete('/evenements/delete/{id}', [EvenementController::class, 'delete'])->name('evenement.delete');
    Route::get('/evenements/{id}', [EvenementController::class, 'show'])->name('evenement.show');
    Route::put('/evenements/{id}', [EvenementController::class, 'update'])->name('evenement.update');

});