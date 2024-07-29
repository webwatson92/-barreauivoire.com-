

<?php
use App\Http\Controllers\Back\TypeDocumentController;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/type-documents', [TypeDocumentController::class, 'index'])->name('type-document.index');
    Route::get('/chargertypedocument', [TypeDocumentController::class, 'chargerListeDeTypeDocument'])->name('charger.liste.typedocument');
    // Route en Post pour Ajouter un type de document dans la base de données
    Route::post('/type-documents/create', [TypeDocumentController::class, 'create'])->name('type-document.create');
    Route::delete('/type-documents/delete/{id}', [TypeDocumentController::class, 'delete'])->name('type-document.delete');
    Route::get('/type-documents/{id}', [TypeDocumentController::class, 'show'])->name('type-document.show');
});

