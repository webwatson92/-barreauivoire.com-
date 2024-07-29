<?php
use App\Http\Controllers\Front\DocumentController;


Route::middleware(['auth', 'verified'])->group(function() {

   //Gestion des documents ou courriers
   Route::get('/liste/de/courrier', [DocumentController::class, 'vueListeDeDocument'])->name('vue.liste.document');
   Route::get('envoyer/un/courrier', [DocumentController::class, 'vueEnvoyerDocument'])->name('vue.envoyer.document');
   Route::post('envoyer/courrier', [DocumentController::class, 'envoyerDocument'])->name('envoyer.document');
   Route::get('/chargerlalistededocument/{user_id}', [DocumentController::class, 'chargerListeDeDocument'])->name('charger.liste.document');
   Route::get('/chargerlalistededocumentlu/{user_id}', [DocumentController::class, 'chargerListeDeDocumentLu'])->name('charger.liste.document.lu');
   Route::get('/chargerlalistededocumentenvoyer/{user_id}', [DocumentController::class, 'chargerListeDeDocumentEnvoyer'])->name('charger.liste.document.envoyer');
   Route::get('/edition/document/{documentId}', [DocumentController::class, 'vueEditionDocument'])->name('vue.edition.document');
   Route::post('/modifier/document', [DocumentController::class, 'modifierDocument'])->name('modifier.document');
   Route::get('/document/afficher/{id}', [DocumentController::class, 'afficherFichier']);
 
  });

