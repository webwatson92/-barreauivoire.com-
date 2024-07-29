<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnuaireController extends Controller
{
    
    
    public function vueListeAnnuaire(){
        return view('front.annuaire.liste');
    }
}
