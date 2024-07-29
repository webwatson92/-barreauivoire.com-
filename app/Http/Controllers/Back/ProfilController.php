<?php

namespace App\Http\Controllers\Back;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Profil};
use Auth;

class ProfilController extends Controller
{
    
    /**
     * Affichage de la page de profil pour modifier mot de passe, nom et email
     */
    public function vueProfil(){
        return view('front.profils.profil');
    }

    /**
     * Affichage de la page de profil pour modification des informations
     */
    public function vueCompteUtilisateur($user_id){
        $utilisateurTrouver = User::findOrFail($user_id);
        if(!is_null($utilisateurTrouver) && !empty($utilisateurTrouver)){
            return view('front.profils.detail-profil', compact('utilisateurTrouver'));
        }
    }

    /**
     * Modification des informations du formulaire de profil
     */
    public function validerModificationCompteUtilisateur(Request $request, $user_id){
        $utilisateurTrouver = User::findOrFail($user_id);
        
        if(!is_null($utilisateurTrouver) && !empty($utilisateurTrouver)){
            // $utilisateurTrouver->code = $request->code;
            $profil = new Profil();
            
            $profil->prenom = $request->prenom;
            $profil->date_naissance = $request->date_naissance;
            $profil->lieu_structure = $request->lieu_structure;
            $profil->login = $utilisateurTrouver->name.'.'.$request->prenom;
            $profil->expertise = $request->expertise ? $request->expertise : "";
            $profil->etat_qualificatif_id = 3;
            $profil->user_id = Auth::user()->id;
            
            $profil->save();
            session()->flash('message', "Modification effectué, en attente de validation par l'administrateur !");
            return redirect()->back();
        }
    }

}

       
