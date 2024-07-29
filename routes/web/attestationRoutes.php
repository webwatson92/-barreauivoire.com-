<?php 
use App\Http\Controllers\Back\AttestationController;


Route::middleware(['auth', 'verified'])->group(function() {
    //Envoi de l'attestation par le Barreau et/ou l'administration
    Route::get('/envoi/du/attestation/{demandeId}' , [AttestationController::class, 'vueEnvoyerAttestation'])->name('vue.envoyer.attestation');
    Route::post('/envoyer/attestation', [AttestationController::class, 'envoyerAttestation'])->name('envoyer.attestation');
});