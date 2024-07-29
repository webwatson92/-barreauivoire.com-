<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Wavey\Sweetalert\Sweetalert;
use App\Models\{Code, User};
use Auth;
use Session;

class GestionDeCode extends Component
{
    public $code_inscription;
    public $r;
    
    public function mount(){
    //    $users = User::where("code", $codeInscription)->first();
    }

    public function ajouterCode(){
        try {
                $code = new Code();
                $codeAleatoire = $this->genererCode();
                $code->code_inscription = $codeAleatoire;
                $code->save();

                session()->flash('message', 'Code enrégistrer avec succès');
                Sweetalert::success('Code enrégistrer avec succès', 'Bien joué');
                return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function genererCode($longueur = 8){
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $longueur; $i++) {
            $code .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $code;
    }

    public function changerStatut($id){
        $code = Code::find($id);
        $codeInscription = $code->code_inscription;
        $user = User::where("code", $codeInscription)->first();
        // dd($code->expires);
        if($code->expires == 0){
            $code->expires = 1;
            $code->save();
            // Alert::toast('Code est activié avec succès !', 'info');
            Sweetalert::success('Code est activié avec succès !', 'Bien joué');
            return redirect()->back();
        }
    }

    public function supprimerCode($id){
        $supprimerCode = Code::find($id);
        if($supprimerCode->expires == 0){
            $supprimerCode->expires = 1;
            $supprimerCode->delete();
            session::flash('message', "Code supprimé");
        }else{
            // Alert::toast('Code déjà attribué à un utilisateur !', 'success');
            session()->flash('message', strtoupper('Code deja attribua a un utilisateur, vous n\'avez pas le droit de le supprime'));
            return redirect()->back();
        }
    }

    public function render()
    {
        $tousLesCodes = Code::paginate(10);
        return view('livewire.back.gestion-de-code', compact('tousLesCodes'));
    }
}
