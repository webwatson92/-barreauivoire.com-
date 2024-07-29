<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, FavorisContact, Attestation, Information, Evenement, Activite, Document, Client};
use Auth;

class AvocatController extends Controller
{    
    public function index(){
        $nombreEvenement = Evenement::count();
        $documentATraiter = Document::where('user_id_2', Auth::user()->id)->count();
        $mesFavoris = FavorisContact::where('user_id', Auth::user()->id)->count();
        $activites = Activite::count();
        $informations = Information::count();
        $nombreClient = Client::where('user_id', Auth::user()->id)->count();
        $courrierEnvoyer = Document::where('user_id', Auth::user()->id)->count();
        $courrierRecu = Document::where('user_id_2', '!=', null)->count();
        $nombreClientEnFavoris = Client::where('user_id', Auth::user()->id)->where('statut', 1)->count();
        // dd($nombreClient);
        return view('front.avocat.index', compact('nombreEvenement', 'informations', 'courrierEnvoyer', 'courrierRecu',
                'mesFavoris', 'documentATraiter', 'nombreClient', 'nombreClientEnFavoris', 'activites'));
    }
}
