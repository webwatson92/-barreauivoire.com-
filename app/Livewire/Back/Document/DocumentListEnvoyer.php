<?php

namespace App\Livewire\Back\Document;

use Livewire\Component;
use App\Models\Document;
use App\Models\{User, Parametre};

class DocumentListEnvoyer extends Component
{
    /**
     * Fonction pour annuler l'envoi d'un document 
     */
    public function AnnulerEnvoiDuDossier($id){
        try {
            $documentTrouver = Document::findOrfail($id);
            if($documentTrouver != null && !empty($documentTrouver)){
                $documentTrouver->etat_qualificatif_id = 5;
                $empreinte = $documentTrouver->empreinte_fichier;
                $documentTrouver->save();
                Parametre::supprimerTampon($empreinte);
                session()->flash('message', "Vous avez annuler l'envoi du document !");
                // return $this->redirect('/liste/de/document', navigate: true);
                return redirect()->route('vue.liste.document')->with("Vous avez annuler l'envoi du document !");
            }else{
                session()->flash('message', "Le document que vous essayez de retirer n'existe pas !");
                // return $this->redirect('/liste/de/document', navigate: true);
                return redirect()->route('vue.liste.document')->with("Vous avez annuler l'envoi du document !");
            }
        } catch (Exception $e) {
        }
        session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());
    }


    public function render()
    {
        return view('livewire.back.document.document-list-envoyer');
    }
}
