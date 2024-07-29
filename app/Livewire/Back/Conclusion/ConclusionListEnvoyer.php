<?php

namespace App\Livewire\Back\Conclusion;

use Livewire\Component;
use App\Models\Conclusion;
use App\Models\{User, Parametre};

class ConclusionListEnvoyer extends Component
{
    /**
     * Fonction pour annuler l'envoi d'un conclusion
     */
    public function AnnulerEnvoiDuDossier($id){
        try {
            $conclusionTrouver = Conclusion::findOrfail($id);
            if($conclusionTrouver != null && !empty($conclusionTrouver)){
                $conclusionTrouver->etat_qualificatif_id = 5;
                $empreinte = $conclusionTrouver->empreinte_fichier;
                // dd($empreinte);
                Parametre::supprimerTampon($empreinte);
                $conclusionTrouver->save();
                session()->flash('message', "Vous avez annuler l'envoi du conclusion !");
                // return $this->redirect('/liste/de/conclusion', navigate: true);
                return redirect()->route('vue.liste.conclusion')->with("Vous avez annuler l'envoi du conclusion !");
            }else{
                session()->flash('message', "Le conclusion que vous essayez de retirer n'existe pas !");
                // return $this->redirect('/liste/de/conclusion', navigate: true);
                return redirect()->route('vue.liste.conclusion')->with("Le conclusion que vous essayez de retirer n'existe pas !");
            }
        } catch (Exception $e) {
        }
        session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.back.conclusion.conclusion-list-envoyer');
    }
}
