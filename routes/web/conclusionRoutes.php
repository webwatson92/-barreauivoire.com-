<?php
use App\Http\Controllers\Front\ConclusionController;

Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des conclusions
    Route::get('/liste/de/conclusion', [ConclusionController::class, 'vueListeDeConclusion'])->name('vue.liste.conclusion');
    Route::get('envoyer/un/conclusion', [ConclusionController::class, 'vueEnvoyerConclusion'])->name('vue.envoyer.conclusion');
    Route::post('envoyer/conclusion', [ConclusionController::class, 'envoyerConclusion'])->name('envoyer.conclusion');
    Route::get('/chargerlalistedeconclusion/{user_id}', [ConclusionController::class, 'chargerListeDeConclusion'])->name('charger.liste.conclusion');
    Route::get('/chargerlalistedeconclusionlu/{user_id}', [ConclusionController::class, 'chargerListeDeConclusionLu'])->name('charger.liste.conclusion.lu');
    Route::get('/chargerlalistedeconclusionenvoyer/{user_id}', [ConclusionController::class, 'chargerListeDeConclusionEnvoyer'])->name('charger.liste.conclusion.envoyer');
    Route::get('/edition/conclusion/{conclusionId}', [ConclusionController::class, 'vueEditionConclusion'])->name('vue.edition.conclusion');
    Route::post('/modifier/conclusion', [ConclusionController::class, 'modifierConclusion'])->name('modifier.conclusion');
});
