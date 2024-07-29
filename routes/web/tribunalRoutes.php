<?php
use App\Http\Controllers\Back\TribunalController;


Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des Tribunaux
    Route::get('/liste/de/tribunal', [TribunalController::class, 'vueListeDeTribunal'])->name('vue.liste.tribunal');
    Route::post('/ajout/de/tribunal', [TribunalController::class, 'ajouterTribunal'])->name('ajouter.tribunal');
    Route::get('/modification/de/tribunal/{id}', [TribunalController::class, 'modifierTribunal'])->name('vue.modification.tribunal');
    Route::post('/modifier/tribunal/{id}', [TribunalController::class, 'modifierTribunal'])->name('modifier.tribunal');
    Route::delete('/supprimer/tribunal/{id}', [TribunalController::class, 'supprimerTribunal'])->name('supprimer.tribunal');
    Route::get('/chargerlalistedestribunaux', [TribunalController::class, 'chargerListeDeTribunaux'])->name('charger.liste.tribunal');
});