<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Profil, Code, User, Evenement, Activite, Information, Document, Ville, Tribunal, Contact, FavorisContact};

class BarreauController extends Controller
{
    public function index(){
        $compteUtilisateur = User::count();
        $nombreEvenement = Evenement::count();
        $profilEnAttenteDeValidation = Profil::where('etat_qualificatif_id', '3')->count();
        $nombreDeContactEnFavorisTotal = FavorisContact::count();

        $tousLesCourriers = Document::count();
        $evenements = Evenement::count();
        $activites = Activite::count();
        $villes = Ville::count();
        $informations = Information::count();
        $tribunaux = Tribunal::count();

        return view('front.barreau.index', compact('nombreDeContactEnFavorisTotal', 'informations',
                    'compteUtilisateur', 'nombreEvenement', 'profilEnAttenteDeValidation', 
                    'tousLesCourriers', 'evenements', 'activites', 'villes', 'tribunaux'));
    }

    public function vueListeDeCode(){
        $tousLesCodes = Code::all();
        return view('front.codes.listedecode', compact('tousLesCodes'));
    }

    /**
     * Comment : Fonction permettant de changer la liste de profil dans le tableau
     */
    public function importerListeDeProfil(Request $request){
        $tousLesProfils = Profil::all();
        dd($tousLesProfils);
        return Datatables::of($listeDesPathologies)
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('libelle', function($tousLesProfils){
            return strtoupper($tousLesProfils->libelle);
        })
        ->addColumn('statut', function ($tousLesProfils) {
            return $tousLesProfils->statut;
        })
        ->addColumn('actions', function ($tousLesProfils) { 
            
            $action = "";
            $msgSuppressionPathologie = "Cliquez ici pour supprimer un profil";
            
            $action .= '<a type="button" class="btn btn-warning" href=""> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <a type="button" class="btn btn-warning" href=""> <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        ';
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

}
