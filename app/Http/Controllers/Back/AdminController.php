<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Profil, Code, User, Evenement, Activite, Information, Document, Ville, Tribunal, Contact, FavorisContact};
use Carbon\Carbon;
use Auth;
use DataTables;

class AdminController extends Controller
{
  
    public function index(){
        $compteUtilisateur = User::count();
        // $nombreEvenement = Evenement::count();
        $profilEnAttenteDeValidation = Profil::where('etat_qualificatif_id', '3')->count();
        $contact = Contact::count();
        $tousLesCourriers = Document::count();
        $evenements = Evenement::count();
        $activites = Activite::count();
        $villes = Ville::count();
        $informations = Information::count();
        $tribunaux = Tribunal::count();
        $nombreDeContactEnFavorisTotal = FavorisContact::count();

        return view('admin.admin', compact('nombreDeContactEnFavorisTotal', 'informations', 'compteUtilisateur', 'contact', 
                        'profilEnAttenteDeValidation', 'tousLesCourriers', 'evenements', 'activites', 'villes', 'tribunaux'
                    ));
    }

    public function vueListeDesParametre(){
        return view('front.parametres.listedeparametre');
    }

    /**
     * 
     */
    public function vueListeDeProfil(){
        $tousLesProfils = Profil::where('id', '!=', Auth::user()->id)->first();
        return view('front.profils.listedeprofil', compact('tousLesProfils'));
    }
    
    
    public function vueCreationDeCompte(){
        $profils = Profil::all();
        return view('front.creationdecompte', compact('profils'));
    }


    /**
     * Affichage de la vue pour la liste avant la validation
     */
    public function validationProfil(){
        $listeProfil = Profil::all();
        return view('droits.profils.listedesprofilsavalider', compact('listeProfil'));
    }

    /**
     * Fonction pour charger la liste des profils en attente de validation
     */
    public function chargerProfil(){
        $listeDesProfilAValider = Profil::all();
        // dd($listeDesProfilAValider);
        $index = 0;

        return Datatables::of($listeDesProfilAValider)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('date_naissance', function ($user) {
                return (!empty($user->date_naissance) && !is_null($user->date_naissance))
                    ? Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y')
                    : '';
            })
            ->addColumn('etat', function ($user) {
                $etat = "";
                switch ($user->etat_qualificatif_id) {
                    case 2:
                        $etat = "Demande valider";
                        break;
                    case 3:
                        $etat = "En attente de validation";
                        break;
                    default:
                        $etat = "En attente de validation";
                        break;
                }
                return $etat;
            })
            ->editColumn('action', function ($user) {
                    $etat = $user->etat_qualificatif_id;
                    $action = "<a href=".route('admin.vue.de.validation', $user->id)." class='btn btn-warning'>
                        <i class='fa-solid fa-list-check'></i>
                        </a>";
                return $etat != 2 ? $action : "";
        })
        ->rawColumns(['numero', 'date_naissance', 'action'])
        ->make(true);
    }

    /**
     * Fonction pour afficher la vue avant que l'admin clique sur accepter ou rejeter
     */
    public function vueAvantValidationDuProfil($id){
        $userInformation = Profil::find($id);
        return view('droits.profils.vueValidation', compact('userInformation'));
    }

    /**
     * Fonction pour gestion de la validation ou de rejet avant le transfert des infos dans la table users id qualification =2
     */
    public function validerProfil(Request $request)
    {
        try {
            // Recherche du profil à valider
            $rechercheDuProfilAValider = Profil::findOrFail($request->idProfil);

            // Mise à jour dans la table profil
            $rechercheDuProfilAValider->etat_qualificatif_id = $request->decision;
            $rechercheDuProfilAValider->save();

            $message = "Rejet des modifications effectuees !"; // Par défaut pour le rejet

            // Transfert des informations dans la table user si decision == 2
            if ($request->decision == 2) {
                $prendreLeCompteDeLutilisateurConcerner = User::findOrFail($rechercheDuProfilAValider->user_id);
                $prendreLeCompteDeLutilisateurConcerner->update([
                    'prenom' => $request->prenom,
                    'date_naissance' => $request->date_naissance,
                    'lieu_structure' => $request->lieu_structure,
                    'expertise' => $request->expertise ?? "",
                ]);

                $message = "Le profil a ete valide avec succes !";
            }

            $class = "alert-success";
            $redirection = route('admin.liste.validation');
        } catch (\Exception $e) {
            $message = "Une erreur s'est produite lors de la validation du profil : " . $e->getMessage();
            $class = "alert-danger";
            $redirection = null; 
        }

        return response()->json([
            'message' => strtoupper($message),
            'class' => $class,
            'redirection' => $redirection,
        ]);
    }



}
