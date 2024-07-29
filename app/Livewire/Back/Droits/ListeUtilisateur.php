<?php

namespace App\Livewire\Back\Droits;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;;

class ListeUtilisateur extends Component
{
    use WithPagination;

    public $search= "";

    public function supprimerUser(User $user){
        $user->delete();
        Alert::toast("Suppression du compte de l'élève effectué avec succès.", 'success');
        return redirect()->route('User');
    }
    
    public function render()
    {
        
        if(!empty($this->search)){
            $listeUtilisateur =  User::where('code', 'LIKE', '%'. $this->search.'%')
                            ->orWhere('name', 'LIKE', '%'. $this->search.'%')
                            ->orWhere('prenom', 'LIKE', '%'. $this->search.'%')
                            ->orWhere('lieu_structure', 'LIKE', '%'. $this->search.'%')
                            ->paginate(10);
            return view('livewire.back.droits.liste-Utilisateur', compact('listeUtilisateur'));
        }else{
            //renvoi de la liste dans cette section 
            /* $anneeActive = SchoolYear::where('active', '1')->first();*/
            $listeUtilisateur =  User::latest()->paginate(10); 
            return view('livewire.back.droits.liste-Utilisateur', compact('listeUtilisateur'));
        } 

        $listeUtilisateur =  User::latest()->paginate(10);
        return view('livewire.back.droits.liste-utilisateur');
    }
}
