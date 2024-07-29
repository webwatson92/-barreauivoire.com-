<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactFavoriController extends Controller
{
    
    public function vueListeDeContactEnFavoris(){
        return view('front.contacts.listedecontactutilisateur');
    }
}
