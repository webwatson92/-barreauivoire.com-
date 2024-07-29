<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{CreationCompteUserRequest, ModificationCompteUserRequest};
use App\Models\{User,HistorisationUser, Profil};
use DataTables;
use Session;
use Auth;
use \Carbon\Carbon;

class DroitsController extends Controller
{
    

    public function acceuilDroits($tabs = null){
        $tabs = (isset($tabs) and !empty($tabs) and !is_null($tabs)) ? $tabs : 'users';
        return view('droits.index', compact("tabs"));
    }

    /**
     * Fonction permettant de charger la liste des membres ou utilisateur
     */
    public function listeDesUtilisateurs(){

        $listeDesUtilisateur = User::where('id', '!=', Auth::user()->id)
            ->where('role', '!=', 'admin')
            ->where('role', '!=', 'barreau')
            ->where('role', '!=', 'superadmin')
            ->orderBy('created_at', 'desc')
            ->get();

        $index = 0;
        return Datatables::of($listeDesUtilisateur)
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('nom_prenom', function ($user) {
            return $user->name . ' ' . $user->prenom;
        })
        ->addColumn('num_toge', function ($user) {
            return $user->num_toge ?? "Pas renseigné";
        })
        ->addColumn('profil', function ($user) {
            return $user->role == "user" ? "Elève Avocat" : $user->role ;
        })
        ->addColumn('date_naissance', function ($user) {
            return (!empty($user->date_naissance) && !is_null($user->date_naissance))
                ? Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y')
                : '';
        })
        ->editColumn('action', function ($user) {
            $role = Auth::user()->role;
            // <a href=".route('admin.liste.details.utilisateur', $user->id)." class='btn btn-primary'>
            //                 <i class='fa-solid fa-eye'></i>
            //             </a>
            return $role === "admin" || $role === "superadmin" ?
                    "
                        <a href=".route('admin.vue.edition.droit.utilisateur', $user->id)." class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i>
                        </a>
                        <a href=".route('admin.supprimer.creation.utilisateur', $user->id)." class='btn btn-danger delete-button' data-id='{{ $user->id }}'>
                            <i class='fa-solid fa-trash'></i>
                        </a>
                    " : 
                    "
                        <a href=".route('admin.vue.edition.droit.utilisateur', $user->id)." class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i>
                        </a>
                    "
                    ;
        })
        ->rawColumns(['id', 'nom_prenom', 'profil', 'date_naissance', 'action'])
        ->make(true);
    }

    /**
     * Affichage du formulaire de création d'un compte 
     */
    public function vueCreerUtilisateur(){
        return view('droits.profils.creationcompte');
    }

    /**
     * Validation pour la création d'un compte
     */
    public function validerCreerUtilisateur(CreationCompteUserRequest $request){
        //  dd($request);
        try {
            $creationompteUtilisateur = new User();
            $creationompteUtilisateur->code = $request->code;
            $creationompteUtilisateur->matricule = $request->matricule;
            $creationompteUtilisateur->name = $request->name;
            $creationompteUtilisateur->prenom = $request->prenom;
            $creationompteUtilisateur->email = $request->email;
            $creationompteUtilisateur->password = bcrypt("monbarreau");
            $creationompteUtilisateur->date_naissance = $request->date_naissance;
            $creationompteUtilisateur->sexe = $request->sexe;
            $creationompteUtilisateur->telephone = $request->telephone;
            $creationompteUtilisateur->lieu_structure = $request->lieu_structure ? $request->lieu_structure : "";
            $creationompteUtilisateur->login = $request->name.'.'.$request->prenom;
            $creationompteUtilisateur->expertise = $request->expertise ? $request->expertise : "";
            $creationompteUtilisateur->num_toge = $request->num_toge ? $request->num_toge : 0;
            $creationompteUtilisateur->role = $request->role;
            $creationompteUtilisateur->save();
            // dd($creationompteUtilisateur);

            session()->flash('message', 'Utilisateur créer avec succès !');
            return redirect()->route('admin.droit.accueil');
        } catch (Exception $e) {
            session()->flash('message', 'Quelque chose à mal fonctionnée.');
        }

    }

    /**
     * Edition du compte de l'utilisateur par l'administrateur ou le barreau
     */
    public function vueEditionUtilisateur(User $user, $id){
        $utilisateurTrouver = User::find($id);
        if(!is_null($utilisateurTrouver) && !empty($utilisateurTrouver)){
            return view('droits.profils.editioncompte', compact('utilisateurTrouver'));
        }
    }

    /**
     * Modification du compte de l'utilisateur par l'administrateur ou le barreau
     */
    public function modifierUtilisateur(ModificationCompteUserRequest $request, $id){
        // try {
            $utilisateurTrouver = User::findOrFail($id);
            // dd($utilisateurTrouver );
            if(!is_null($utilisateurTrouver) && !empty($utilisateurTrouver)){
                //Je dois mettre dans une transaction
                $utilisateurTrouver->code = $request->code;
                $utilisateurTrouver->name = $request->name;
                $utilisateurTrouver->prenom = $request->prenom;
                $utilisateurTrouver->email = $request->email;
                $utilisateurTrouver->password = bcrypt("monbarreau");
                $utilisateurTrouver->date_naissance = $request->date_naissance;
                $utilisateurTrouver->sexe = $request->sexe;
                $utilisateurTrouver->telephone = $request->telephone;
                $utilisateurTrouver->lieu_structure = $request->lieu_structure ? $request->lieu_structure : "";
                $utilisateurTrouver->login = $request->name.'.'.$request->prenom;
                $utilisateurTrouver->expertise = $request->expertise ? $request->expertise : "";
                $utilisateurTrouver->num_toge = $request->num_toge ? $request->num_toge : 0;
                $utilisateurTrouver->role = $request->role;
                $utilisateurTrouver->save();
                session()->flash('message', 'Utilisateur modifié avec succès !');
                
                User::historiserCreationOrModificationCompte($request);
                // dd($historique);
                return redirect()->route('admin.droit.accueil');
            }
        // } catch (\Throwable $th) {
        //     session()->flash('message', 'Quelque chose à mal fonctionnée.');
        // }
    }

    /**
     * Detail du profil
     */
    public function listeDeDetailsUtilisateurs($id){
        dd('ok');
    }

    
    

    /**
     * Suppression d'un compte utilisateur
     */
    public function supprimerCompteUtilisateur($id){
        $utilisateurTrouver = User::where('id', $id)->first();

        if (!$utilisateurTrouver) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        
        if ($utilisateurTrouver) {
           
            $utilisateurTrouver->deleted_at = now();
            $utilisateurTrouver->save();

            $historique = new HistorisationUser(); 
            $historique->name = $utilisateurTrouver->name;
            $historique->prenom = $utilisateurTrouver->prenom ?? " ";
            $historique->action = "deleted";
            $historique->user_id = Auth::user()->id;
            $historique->save();

            session()->flash('message', 'Utilisateur supprimé avec succès !');
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression de l\'utilisateur.');
        }

    }

}
