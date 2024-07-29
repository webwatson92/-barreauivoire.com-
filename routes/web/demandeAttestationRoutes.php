<?php
use App\Http\Controllers\Front\DemandeAttestationController;


Route::middleware(['auth', 'verified'])->group(function() {

    //Gestion des demandes d'attestation
    Route::get('/liste/attestation', [DemandeAttestationController::class, 'vueListeDemandeAttestation'])->name('vue.liste.demande.attestation');
    Route::get('/demande/attestation' , [DemandeAttestationController::class, 'vueDemandeAttestation'])->name('vue.demande.attestation');
    Route::get('/voir/attestation' , [DemandeAttestationController::class, 'voirAttestation'])->name('voir.attestation');
    Route::get('/chargerlalistededemandeattestation/{user_id}', [DemandeAttestationController::class, 'chargerListeDeDemandeAttestation'])->name('charger.liste.demande.attestation');
    Route::get('/chargerlalistededemandeattestationadmin/{user_id}', [DemandeAttestationController::class, 'chargerListeDeDemandeAttestationAdmin'])->name('charger.liste.demande.attestation.admin');
});