<?php

namespace App\Livewire\Back\Document;

use Livewire\Component;
use App\Models\{Document, Statut};
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;

class EditionDocument extends Component
{
    use WithFileUploads;
    public Document $document;
    public $documentId;
    public $titre;
    public ?UploadedFile $contenu;
    public $date_cloture;
    public $pertinance;
    public $nomFichier;
    public $base64Data;

    public function mount($documentInfo){
        $this->document = $documentInfo;
        $this->titre = $documentInfo->titre;
        $this->date_cloture = $documentInfo->date_cloture;
        $this->pertinance = $documentInfo->pertinance;
        $this->contenu = null; 
    }

    public function update(){
        // Définition des règles de validation
        $validationRules = [
            'titre' => 'required|string',
            'date_cloture' => 'required|date',
            'pertinance' => 'required|string',
        ];
        
        // Ajout de la règle de validation pour le contenu si présent
        if ($this->contenu) {
            $validationRules['contenu'] = 'nullable|mimes:pdf|max:2048';
            dd($this->contenu);
        }
    
        // Validation des données selon les règles définies
        $this->validate($validationRules);
    
        // Mise à jour des données dans la base de données
        Document::where('id', $this->document->id)->update([
            'titre' => $this->titre,
            'date_cloture' => $this->date_cloture,
            'pertinance' => $this->pertinance,
        ]);
    
        // Traitement du contenu du fichier si présent
        if (isset($this->contenu)) {
            // Obtenir le contenu du fichier PDF
            $contenu = file_get_contents($this->contenu->path());
            $this->base64Data = base64_encode($contenu);
            // Obtenez le nom du fichier
            $this->nomFichier = $this->contenu->getClientOriginalName();
            
            // Mise à jour du contenu dans la base de données
            Document::where('id', $this->document->id)->update([
                'contenu' => $this->base64Data,
            ]);
        } 
    
        // Redirection avec un message flash
        session()->flash('message', 'Le document a été mis à jour!');
        return $this->redirect('/liste/de/document', navigate: true);
    }
    
    

    public function render()
    {
        $statuts = Statut::all();
        return view('livewire.back.document.edition-document', compact('statuts'));
    }
}
