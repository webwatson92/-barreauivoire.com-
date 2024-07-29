<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangerMotDePasseRequest;
use Auth;
use App\Models\{User, FavorisContact, Attestation, Information, Evenement, Activite, Document, Client};
use \Carbon\Carbon;

class UserAdminController extends Controller
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
        return view('front.users.index', compact('nombreEvenement', 'informations', 'courrierEnvoyer', 'courrierRecu',
                'mesFavoris', 'documentATraiter', 'nombreClient', 'nombreClientEnFavoris', 'activites'));
    }

    public function vueChangerMotDePasse(){
        $user = Auth::user();
        // dd($user);
        return view('front.change-password', compact('user'));
    }

    public function validerChangerMotDePasse(ChangerMotDePasseRequest $request){
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->password_change_at = now();
        $user->save();
        // dd($user);

        // $this->generateAndSendTwoFactorCode($user);
        
        return redirect()->route('verify.index');

    }
}
