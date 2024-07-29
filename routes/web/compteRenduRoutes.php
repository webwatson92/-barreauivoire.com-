<?php
use App\Http\Controllers\Front\CompteRenduController;

Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des comptes rendus
    Route::get('/compte-rendus', [CompteRenduController::class, 'vueCompteRendu'])->name('vue.compte-rendu');
    Route::get('/chargerdocumentcompterendu', [CompteRenduController::class, 'chargerListeDeCompteRendu'])->name('charger.liste.compterendu');
    Route::post('compte-rendus/create', [CompteRenduController::class, 'create'])->name('creer.compterendu');
    Route::delete('/compte-rendus/delete/{id}', [CompteRenduController::class, 'delete'])->name('supprimer.compterendu');
    Route::get('/compte-rendus/afficher/{id}', [CompteRenduController::class, 'afficherFichier'])->name('modification.compterendu');
    // Route::get('/compte-rendus/{id}', [CompteRenduController::class, 'afficherFichier'])->name('compteRendu.index');
});