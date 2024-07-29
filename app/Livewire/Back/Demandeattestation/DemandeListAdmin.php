<?php

namespace App\Livewire\Back\Demandeattestation;

use Livewire\Component;
use App\Models\DemandeAttestation;
use App\Models\User;

class DemandeListAdmin extends Component
{
    public function validerDemande($id){
        $demandeTrouver = DemandeAttestation::where('id',$id)->first();
        try{
            if(!is_null($demandeTrouver) && !empty($demandeTrouver)){
                $demandeTrouver->etat_qualificatif_id = 2;
                $demandeTrouver->save();

                //historisation
                User::historiserValidationOuRejeterDemandeAttestation($demandeTrouver->etat_qualificatif_id);

                Session()->flash('message', "Demande valider avec succès. Vous devez ensuite envoyé l'attestation concernée.");
                return $this->redirect('/liste/attestation', navigate: true);
            }else{
                Session()->flash('message', "La demande que vous essayer de supprimer n'existe pas !");
                return redirect()->back();
            }
        }catch(Exception $e){
            Session()->flash('message', "Une erreur s'est produite lors du traitement : ".$e->getMessage());
        }
    }

    public function rejeterDemande($id){
        $demandeTrouver = DemandeAttestation::where('id',$id)->first();
        try{
            if(!is_null($demandeTrouver) && !empty($demandeTrouver)){
                $demandeTrouver->etat_qualificatif_id = 4;
                $demandeTrouver->save();
                User::historiserValidationOuRejeterDemandeAttestation($demandeTrouver->etat_qualificatif_id);
                Session()->flash('message', "Demande rejeter.");
                return $this->redirect('/liste/attestation', navigate: true);
            }else{
                Session()->flash('message', "La demande que vous essayer de supprimer n'existe pas !");
                return redirect()->back();
            }
        }catch(Exception $e){
            Session()->flash('message', "Une erreur s'est produite lors du traitement : ".$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.back.demandeattestation.demande-list-admin');
    }
}
