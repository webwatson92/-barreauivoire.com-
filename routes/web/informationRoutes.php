<?php

use App\Http\Controllers\Back\InformationController;

Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des information du barreau
    Route::get('/informations', [InformationController::class, 'index'])->name('information.index');
    Route::get('/chargerdocumentInformation', [InformationController::class, 'chargerListeInformation'])->name('charger.liste.information');
    // Route en Post pour Ajouter une information dans la base de données
    Route::post('/informations/create', [InformationController::class, 'create'])->name('information.create');
    Route::delete('/informations/delete/{id}', [InformationController::class, 'delete'])->name('information.delete');
    Route::get('/informations/{id}', [InformationController::class, 'show'])->name('information.show');
    Route::put('/informations/{id}', [InformationController::class, 'update'])->name('information.update');
    //Send Email Information
    Route::get('/informations/sendmail/{id}', [InformationController::class, 'sendEmailInformation'])->name('information.send');

});