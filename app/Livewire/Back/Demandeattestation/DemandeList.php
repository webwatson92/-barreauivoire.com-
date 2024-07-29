<?php

namespace App\Livewire\Back\Demandeattestation;

use Livewire\Component;
use Auth;
use App\Models\DemandeAttestation;


class DemandeList extends Component
{
    public function deletePost($id){
        DemandeAttestation::where('id',$id)->delete();
        Session()->flash('message', 'Demande supprimé !');
        return $this->redirect('/liste/attestation', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.demandeattestation.demande-list');
    }
}
