

<?php
use App\Http\Controllers\Back\FaqController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/faqs', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/chargerdocumentfaq', [FaqController::class, 'chargerListeFaq'])->name('charger.liste.faq');
    // Route en Post pour Ajouter un Guide dans la base de données
    Route::post('/faqs/create', [FaqController::class, 'create'])->name('faq.create');
    Route::delete('/faqs/delete/{id}', [FaqController::class, 'delete'])->name('faq.delete');
    Route::get('/faqs/show/{id}', [FaqController::class, 'show'])->name('faq.show');
    Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('faq.update');
});

