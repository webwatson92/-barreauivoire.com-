<?php

namespace App\Livewire\Back\Demandeattestation;

use Livewire\Component;
use App\Models\DemandeAttestation;;
use Auth;
use Carbon\Carbon;

class Demande extends Component
{
    public function envoyerDemandeAttestation(){
        $verifierSiDemandeExiste = DemandeAttestation::where('user_id', Auth::user()->id)->where('etat_qualificatif_id', 3)->latest()->first();
        // dd($verifierSiDemandeExiste);
        if(empty($verifierSiDemandeExiste) && is_null($verifierSiDemandeExiste)){
            
            $demande = new DemandeAttestation();
            $demande->date_demande = now();
            $demande->etat_qualificatif_id = 3;
            $demande->user_id = Auth::id();
            $demande->save();
            session()->flash('message', "Demande envoyé au barreau avec succès !");
            return $this->redirect('/liste/attestation', navigate: true);
        }

        session()->flash('message', "Vous avez une demande en attente de validation. Patientez la validation du barreau!");
        return $this->redirect('/liste/attestation', navigate: true);
    }

    

    public function render()
    {
        return view('livewire.back.demandeattestation.demande');
    }
}
