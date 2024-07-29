<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Alert;
use App\Models\{User, Profil};
use Session;
use Str;

class ChangerStatutEtSupprimer extends Component
{
    public $libelle, $route;
    public $search = "";

    public function mount(){

    }
    

    public function ajouterProfil(Profil $profil)
    {
        
        $this->validate([
            'libelle' => 'required|string',
            'route' => 'required|string',
        ]);

        try {
            $data = [
                'libelle' => $this->libelle,
                'route' => $this->route
            ];
            // $profil->libelle = $this->libelle;
            // $profil->route = $this->route;
            $profil->create($data);
            return redirect()->back(); 
            session()->flash('message', 'Votre entreprise à été enrégistrer avec succès');

        } catch (Exeception $e) {
            dd($e);
        }
    }

    public function changerStatut($id){
        try {
            $profil = Profil::find( $id);
            if($profil->statut == 1){
                $profil->statut = 0;
                $profil->save();
                // Alert::toast('Profil est activié avec succès !', 'info');
            }else{
                $profil->statut = 1;
                $profil->save();
                // Alert::toast('Profil est désactivié avec succès !', 'success');
            }
            return redirect()->back();
        } catch (Exeception $e) {
            //throw $th;
        }
    }

    public function supprimerProfil($id){
        $suppimer = Profil::find($id);
        $suppimer->delete();
        session::flash('message', "Profil supprimé");
        // Alert::toast("Profil supprimé", 'danger')->autoclose(1000);
        // return redirect()->back();
    }

    public function render()
    {
        $tousLesProfils = Profil::paginate(10);
        return view('livewire.back.changer-statut-et-supprimer', compact('tousLesProfils'));
    }
}
