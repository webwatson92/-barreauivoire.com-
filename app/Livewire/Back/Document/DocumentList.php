<?php

namespace App\Livewire\Back\Document;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Document;
use App\Models\{User, Parametre};

class DocumentList extends Component
{
    use WithPagination;
    public $matricule, $empreinte_fichier,  $titre, $nomfichier, $contenu, $date_cloture, $etat_qualificatif_id, $utilisateur_recevant_id;
    public $nomComplet;

    protected $rules = [
        'titre' => 'required|string',
        'contenu' => 'required|file|mimes:pdf|max:2048',
        'date_cloture' => 'required|date',
    ];

    // public function updated($propertyName)
    // {
    //     if ($propertyName === 'matricule') {
    //         $user = User::where('matricule', $this->matricule)->first();
    //         if ($user) {
    //             $this->nomComplet = $user->name ." ".$user->prenom;
    //             // dd("lalala");
    //         }
    //     }
    // }

    public function updatedMatricule()
    {
        $user = User::where('matricule', $this->matricule)->first();
        if ($user) {
            $this->nomComplet = $user->name ." ".$user->prenom;
        }
    }


    // public function save()
    // {
    //     $this->validate();
        
    //     // Stockez le contenu du fichier PDF dans la base de données
    //     $contenu = $this->contenu->get();

    //     $document = new Document();
    //     $document->titre = $this->titre;
    //     $document->nomfichier = $this->nomfichier;
    //     $document->contenu = $contenu;
    //     $document->date_cloture = $this->date_cloture;
    //     $document->etat_qualificatif_id = 3;
    //     $document->save();  

    //     // Associez le document à l'utilisateur actuel
    //     auth()->user()->documents()->attach($document->id);

    //     // Associez le document à l'utilisateur qui le reçoit (s'il existe)
    //     if ($this->utilisateur_recevant_id) {
    //         $utilisateurRecevant = User::find($this->utilisateur_recevant_id);
    //         if ($utilisateurRecevant) {
    //             $utilisateurRecevant->documents()->attach($document->id);
    //         }
    //     }

    //     $this->reset(['matricule', 'titre', 'nomfichier', 'contenu', 'date_cloture', 'nomComplet']);
    //     session()->flash('message', "Document envoyé avec succès !");
    //     return $this->redirect('/liste/de/document', navigate: true);
    // }

    /**
     * Fonction pour valider les différent document en cour de traitement
     */
    public function traiterDossier($id){
        try {
            $documentTrouver = Document::findOrfail($id);
            if($documentTrouver != null && !empty($documentTrouver)){
                $documentTrouver->etat_qualificatif_id = 6;
                $documentTrouver->save();
                session()->flash('message', "Document traiter avec succès !");
                // return $this->redirect('/liste/de/courrier', navigate: true);
                return redirect()->route('vue.liste.document')->with("Document traiter avec succès !");
            }else{
                session()->flash('message', "Le courrier que vous essayez de traiter n'existe pas !");
                return redirect()->route('vue.liste.document')->with("Le courrier que vous essayez de traiter n'existe pas !");
                // return $this->redirect('/liste/de/courrier', navigate: true);
            }
        } catch (Exception $e) {
            session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Fonction pour accuser la réception d'un document
     */
    public function AccuserDeReceptionDuDossier($id){
        try {
            $documentTrouver = Document::findOrfail($id);
            if($documentTrouver != null && !empty($documentTrouver)){
                $documentTrouver->estLuOuPas = 1;
                $documentTrouver->etat_qualificatif_id = 2;
                $documentTrouver->save();
                session()->flash('message', "Vous avez valider la reception du document avec succès !");
                // return $this->redirect('/liste/de/courrier', navigate: true);
                return redirect()->route('vue.liste.document')->with("Vous avez valider la reception du document avec succès !");
            }else{
                session()->flash('message', "Le courrier que vous essayez d'accuser reception n'existe pas !");
                return redirect()->route('vue.liste.document')->with("Le courrier que vous essayez d'accuser reception n'existe pas !");

                // return $this->redirect('/liste/de/courrier', navigate: true);
            }
        } catch (Exception $e) {
        }
        session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());

    }

    public function deletePost($id){
        $documentTrouver = Document::find($id);
        $empreinte = $documentTrouver->empreinte_fichier;
        Document::where('id',$id)->delete();
        Parametre::supprimerTampon($empreinte);
        Session()->flash('message', 'courrier supprimé !');
        return $this->redirect('/liste/de/courrier', navigate: true);
    }

    public function render()
    {
        return view('livewire.back.document.document-list');
    }
}
