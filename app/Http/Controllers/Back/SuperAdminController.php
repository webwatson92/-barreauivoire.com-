<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\{Profil, Code, User, Evenement, Activite, Information, Document, Ville, Tribunal, Contact, FavorisContact};
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{

    public function index(){
        $compteUtilisateur = User::count();
        $profilEnAttenteDeValidation = Profil::where('etat_qualificatif_id', '3')->count();
        $tousLesCourriers = Document::count();
        $evenements = Evenement::count();
        $activites = Activite::count();
        $villes = Ville::count();
        $informations = Information::count();
        $tribunaux = Tribunal::count();

        return view('front.superadmin', compact('informations', 'compteUtilisateur',
            'profilEnAttenteDeValidation', 'tousLesCourriers', 'evenements', 'activites', 'villes', 'tribunaux'
        ));
    }
}
