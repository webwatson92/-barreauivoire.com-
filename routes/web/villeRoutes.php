<?php
use App\Http\Controllers\Back\VilleController;


Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des Tribunaux
    Route::get('/liste/des/villes', [VilleController::class, 'vueListeDeVille'])->name('vue.liste.ville');
    Route::post('/ajout/de/ville', [VilleController::class, 'ajouterVille'])->name('ajouter.ville');
    Route::get('/modification/de/ville/{id}', [VilleController::class, 'modifierVille'])->name('vue.modification.ville');
    Route::post('/modifier/ville/{id}', [VilleController::class, 'modifierVille'])->name('modifier.ville');
    Route::delete('/supprimer/ville/{id}', [VilleController::class, 'supprimerVille'])->name('supprimer.ville');
    Route::get('/chargerlalistedesville', [VilleController::class, 'chargerListeDeVille'])->name('charger.liste.ville');
});