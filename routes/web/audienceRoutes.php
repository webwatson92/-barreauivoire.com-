<?php
use App\Http\Controllers\Front\AudienceController;

Route::middleware(['auth', 'verified'])->group(function() {
    //Gestion des Audiences
    Route::get('/liste/audience', [AudienceController::class, 'vueListeDeAudience'])->name('vue.liste.audience');
    Route::get('/un/confrere/trouver', [AudienceController::class, 'vueResultatRecherche'])->name('vue.resultat.recherche');
    Route::post('/ajouter/audience', [AudienceController::class, 'ajouterAudience'])->name('ajouter.audience');
    Route::get('/modification/audience/{id}', [AudienceController::class, 'modifierAudience'])->name('vue.modification.audience');
    Route::post('/modifier/audience/{id}', [AudienceController::class, 'modifierAudience'])->name('modifier.audience');
    Route::delete('/supprimer/audience/{id}', [AudienceController::class, 'supprimerAudience'])->name('supprimer.audience');
    Route::get('/chargerlalistedesaudience', [AudienceController::class, 'chargerListeDeAudience'])->name('charger.liste.audience');
    Route::get('/recherche/une/audience', [AudienceController::class, 'vueRechercheAudience'])->name('vue.recherche.audience');
    Route::post('/rechercher/audience', [AudienceController::class, 'rechercherAudience'])->name('rechercher.audience');
});