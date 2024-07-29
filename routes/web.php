<?php
use App\Livewire\Back\Contact\ContactList;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Middleware\Admin;
use App\Http\Middleware\User;
use App\Http\Middleware\TwoFactor;
use App\Http\Controllers\Front\{
        DocumentController,
        UserAdminController, UserSalleController, ContactFavoriController, ClientController,
};
use App\Http\Controllers\Auth\{TwoFactorController, LoginController};
use App\Http\Controllers\Back\{ 
    AdminController, DroitsController, ProfilController, ContactController, AnnuaireController,
    SalleController
};

// monordreetmoi.com/liste/de/document => affiche un erreur 404
// donc je fais une redirection vers une page qui fonction.
Route::redirect('/liste/de/document', '/liste/de/courrier');

Route::view('/', 'welcome');
  
// Route::get('list', [MyTestController::class, 'dataTableLogic'])->name('liste');//pour le test de datatable

// Route::get("/testlist", [MyTestController::class, 'test'])->name('testliste');

Route::middleware(['auth', 'verified'])->group(function() {
    
   
    // Chargement des vues des droits
    Route::get('/droits/accueil', [DroitsController::class, 'acceuilDroits'])->name('admin.droit.accueil');
    Route::get('/liste/des/utilisateurs', [DroitsController::class, 'listeDesUtilisateurs'])->name('admin.liste.utilisateurs');//datatable
    
    //Profil Utilisateur & admin
    Route::get('/mon/profil', [ProfilController::class, 'vueProfil'])->name('vue.profil.utilisateur');

    // Creation d'un compte utilisateur avec son rôle
    Route::get('/liste/de/details/utilisateurs/{user_id}', [DroitsController::class, 'listeDeDetailsUtilisateurs'])->name('admin.liste.details.utilisateur');
    Route::get('/creation/compte/utilisateur',  [DroitsController::class, 'vueCreerUtilisateur'])->name('admin.vue.creation.utilisateur');
    Route::post('/creer/utilisateur',  [DroitsController::class, 'validerCreerUtilisateur'])->name('admin.creer.utilisateur');
    Route::get('/edition/utilisateur/{user_id}', [DroitsController::class, 'vueEditionUtilisateur'])->name('admin.vue.edition.droit.utilisateur');
    Route::post('/edition/utilisateur/{user_id}', [DroitsController::class, 'modifierUtilisateur'])->name('admin.modifier.utilisateur');
    Route::get('/supprimer/utilisateur/{user_id}',  [DroitsController::class, 'supprimerCompteUtilisateur'])->name('admin.supprimer.creation.utilisateur');
    
    Route::get('/changement/du/mot/de/passe', [UserAdminController::class, 'vueChangerMotDePasse'])->name('vue.changer.motdepasse');
    Route::post('/changement/du/mot/de/passe', [UserAdminController::class, 'validerChangerMotDePasse'])->name('valider.changer.motdepasse');
    
    //Gestion contact Admin & barreau
    Route::get('/liste/de/contact', [ContactController::class, 'vueListeDeContact'])->name('vue.liste.contact');
    Route::get('/edition/contact/{contactId}', [ContactController::class, 'vueEditionContact'])->name('vue.edition.contact');
    Route::get('/chargerlalistedecontact', [ContactController::class, 'chargerListeDeContact'])->name('charger.liste.contact');
    Route::get('/chargerlalistedecontactfavoris', [ContactController::class, 'chargerListeDeContactFavoris'])->name('charger.liste.contact.favoris');

    //Gestion des salles par l'admin & barreau
    Route::get('/liste/de/salle', [SalleController::class, 'vueListeDeSalle'])->name('vue.liste.salle');
    Route::get('/chargerlalistedesalle', [SalleController::class, 'chargerLaListeDesSalle'])->name('charger.liste.salle');
    Route::get('enregistrer/une/salle', [SalleController::class, 'vueEnregistrerSalle'])->name('vue.enregistrer.document');
    Route::post('enregistrer/salle', [SalleController::class, 'enregistrerSalle'])->name('enregistrer.salle');
    Route::get('/edition/salle/{salleId}', [SalleController::class, 'vueEditionSalle'])->name('vue.edition.salle');
    Route::post('/modifier/salle', [SalleController::class, 'modifierSalle'])->name('modifier.salle');

    //Liste des salle vu par l'avocat ou l'eleve
    Route::get('/consultation/liste/de/salle', [UserSalleController::class, 'listeSalle'])->name('liste.user.salle');


    //Gestion des clients par membre
    Route::get('/liste/de/client', [ClientController::class, 'vueListeDeClient'])->name('vue.liste.client');
    Route::get('/edition/client/{clientId}', [ClientController::class, 'vueEditionClient'])->name('vue.edition.client');
    Route::get('/chargerlalistedeclient', [ClientController::class, 'chargerListeDeClient'])->name('charger.liste.client');
    Route::get('/chargerlalistedeclientfavoris', [ClientController::class, 'chargerListeDeClientFavoris'])->name('charger.liste.client.favoris');

    //Gestion de l'annuaire
    Route::get('/liste/de/mon/annuaire', [AnnuaireController::class, 'vueListeAnnuaire'])->name('vue.liste.annuaire');

    //Charger le nom et prenom en fonction du matricule 
    Route::get('/chargerlenometprenomajax/{matricule}', [DocumentController::class, 'chargerLeNomEtLePrenom'])->name('charger.nomcomplet.document');
    
    Route::middleware([TwoFactor::class])->group(function () {
        Route::get('/accueil', [UserAdminController::class, 'index'])->name('admin.home');
        // Route::get('/verifier-code-authentification', [AuthentificationCode::class, 'index'])->name('verify.index');
        Route::get('/verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
        Route::prefix('verify')->name('verify.')->group(function () {
            Route::get('/', [TwoFactorController::class, 'index'])->name('index');
            Route::post('/', [TwoFactorController::class, 'store'])->name('store');
        });
    });

    Route::get('/mon/compte/{user_id}', [ProfilController::class, 'vueCompteUtilisateur'])->name('vue.compte.utilisateur');
    Route::post('/mon/compte/{user_id}', [ProfilController::class, 'validerModificationCompteUtilisateur'])->name('user.modifier.utilisateur');
    Route::get('/editionrole/{profil}/edit',[UserAdminController::class, ' EditionRole'])->name('compte.edit');
    Route::view('profile', 'profile')->name('profile');

    //Validation de modification d'un compte
    Route::get('/listedeprofil', [AdminController::class, 'vueListeDeProfil'])->name('vue.listedeprofil');
    Route::get('/liste/de/parametre', [AdminController::class, 'vueListeDesParametre'])->name('vue.listedesparametre');
    
    //validation par le barreau et l'admin
    Route::get('/validation/profils',[AdminController::class, 'validationProfil'])->name('admin.liste.validation');
    Route::get('/validation/profil',[AdminController::class, 'chargerProfil'])->name('admin.charger.liste.validation');
    Route::get('/page/de/validation/{id}',[AdminController::class, 'vueAvantValidationDuProfil'])->name('admin.vue.de.validation');
    Route::post('/valider/{id}',[AdminController::class, 'validerProfil'])->name('admin.valider.validation');

    Route::prefix('espace-profil')->group(function () {
        Route::get('/', [ProfilController::class, 'vueProfil'])->name('vue.profil');
        Route::post('/', [ProfilController::class, 'valider'])->name('valider.profil');
    });
});

foreach (File::allFiles(__DIR__ . '/web') as $route_file) {
    require $route_file->getPathname();
}

Route::get('login_', [LoginController::class, 'login'])->name('login_');
Route::post('login_', [LoginController::class, 'verifierConnexion'])->name('logged');

require __DIR__.'/auth.php';
