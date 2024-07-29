<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salle;

class UserSalleController extends Controller
{
    
    public function listeSalle(){
        $salle = Salle::all();
        return view('front.salle.listedesalle', compact('salle'));
    }
}
