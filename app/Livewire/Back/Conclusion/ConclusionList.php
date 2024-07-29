<?php

namespace App\Livewire\Back\Conclusion;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Conclusion;
use App\Models\User;

class ConclusionList extends Component
{
    use WithPagination;
    public $matricule,  $titre, $nomfichier, $contenu, $date_cloture, $etat_qualificatif_id, $utilisateur_recevant_id;
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

    //     $conclusion = new Document();
    //     $conclusion->titre = $this->titre;
    //     $conclusion->nomfichier = $this->nomfichier;
    //     $conclusion->contenu = $contenu;
    //     $conclusion->date_cloture = $this->date_cloture;
    //     $conclusion->etat_qualificatif_id = 3;
    //     $conclusion->save();  

    //     // Associez le document à l'utilisateur actuel
    //     auth()->user()->documents()->attach($conclusion->id);

    //     // Associez le document à l'utilisateur qui le reçoit (s'il existe)
    //     if ($this->utilisateur_recevant_id) {
    //         $utilisateurRecevant = User::find($this->utilisateur_recevant_id);
    //         if ($utilisateurRecevant) {
    //             $utilisateurRecevant->documents()->attach($conclusion->id);
    //         }
    //     }

    //     $this->reset(['matricule', 'titre', 'nomfichier', 'contenu', 'date_cloture', 'nomComplet']);
    //     session()->flash('message', "Document envoyé avec succès !");
    //     return $this->redirect('/liste/de/document', navigate: true);
    // }

    /**
     * Fonction pour valider les différent document en cour de traitemn
     */
    public function traiterDossier($id){
        try {
            $conclusionTrouver = Conclusion::findOrfail($id);
            if($conclusionTrouver != null && !empty($conclusionTrouver)){
                $conclusionTrouver->etat_qualificatif_id = 6;
                $conclusionTrouver->save();
                session()->flash('message', "Document traiter avec succès !");
                return $this->redirect('/liste/de/conclusion', navigate: true);
            }else{
                session()->flash('message', "La conclusion que vous essayez de traiter n'existe pas !");
                return $this->redirect('/liste/de/conclusion', navigate: true);
            }
        } catch (Exception $e) {
        }
        session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());

    }

    /**
     * Fonction pour accuser la réception d'un document
     */
    public function AccuserDeReceptionDuDossier($id){
        try {
            $conclusionTrouver = Conclusion::findOrfail($id);
            if($conclusionTrouver != null && !empty($conclusionTrouver)){
                $conclusionTrouver->estLuOuPas = 1;
                $conclusionTrouver->etat_qualificatif_id = 2;
                $conclusionTrouver->save();
                session()->flash('message', "Vous avez valider la reception de la conclusion avec succès !");
                // return $this->redirect('/liste/de/conclusion', navigate: true);
                return redirect()->route('vue.liste.conclusion')->with('Vous avez valider la reception de la conclusion avec succès !');
            }else{
                session()->flash('message', "La conclusion que vous essayez d'accuser reception n'existe pas !");
                // return $this->redirect('/liste/de/conclusion', navigate: true);
                return redirect()->route('vue.liste.conclusion')->with("La conclusion que vous essayez d'accuser reception n'existe pas !");
            }
        } catch (Exception $e) {
        }
        session()->flash('message', "Quelque chose à mal fonctionnée !".$e->getMessage());

    }

    public function deletePost($id){
        $conclusionTrouver = Conclusion::find($id);
        $empreinte = $documentTrouver->empreinte_fichier;
        Conclusion::where('id',$id)->delete();
        Parametre::supprimerTampon($empreinte);
        Session()->flash('message', 'Conclusion supprimé !');

        // return $this->redirect('/liste/de/conclusion', navigate: true);
        return redirect()->route('vue.liste.conclusion');
    }

    public function render()
    {
        return view('livewire.back.conclusion.conclusion-list');
    }
}
