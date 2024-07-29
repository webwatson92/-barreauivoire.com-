<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutreProfilController extends Controller
{
  
    
    public function avocatext(){
        return view('front.avocatext.index');
    }

    public function eleveavocat(){
        return view('front.eleveavocat.index');
    }
}
