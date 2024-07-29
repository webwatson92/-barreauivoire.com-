<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\Guest;
use Auth;


use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Notifications\TwoFactorCode;

class LoginController extends Controller
{
    public function login(){
        return view('login');
    }

    public function verifierConnexion(Request $request){
        // $this->validate();
        
        if (!is_null($request) && isset($request->identifiant)) {
            $user = User::where('email', $request->identifiant)->orWhere('login', $request->identifiant)->first();
            if (!is_null($user)) {
                if (Auth::attempt(['email' => $request->identifiant, 'password' => $request->password], $request->remember)) {
                    // dd($user);
                    Session::regenerate();
                    if ($user->password_change_at === null) {
                        
                        $this->generateAndSendTwoFactorCode($user);
                        // $this->redirectIntended(default: );
                        return redirect()->route('vue.changer.motdepasse');
                    } else {
                        $user = User::where('email', $request->identifiant)->first();
                        $this->generateAndSendTwoFactorCode($user);
                        // $this->redirectIntended(default: , navigate: true);
                        return redirect()->route('verify.index');
                    }
                } else {
                    Session()->flash('message', "Combinaison incorecte");
                    return redirect()->back();
                }
            } else {
                Session()->flash('message', "Utilisateur non trouvé!");
                return redirect()->back();
            }
        } else {
            Session()->flash('message', "Veuillez renseignez les champs obligatoire (*)");
            return redirect()->back();
        }
    }

    
    protected function generateAndSendTwoFactorCode($user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
}
