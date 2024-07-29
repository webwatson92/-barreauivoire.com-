<?php

namespace App\Livewire\Back\Client;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use Auth;

class ClientList extends Component
{
    use WithPagination;
    public $code, $nom, $adresse, $tel, $source, $montant, $modelId;
    
    public $user;

    protected $listeners = ['refreshParent' => '$refresh', 'getModelId', 'openDeleteModal'];
    // protected $listeners = ['openDeleteModal'];

    public function render()
    {
        return view('livewire.back.client.client-list');
    }

   

    public function mount()
    {
        $user = Auth::user()->id;
        $this->user = $user;
    }

    public function save()
    {
        $this->validate([
            'nom' => "required|string",
            'adresse' => "required|string",
            'tel' => "required|string",
            'montant' => "required|integer",
        ]);

        $data = [
            'code' => $this->code,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'tel' => $this->tel,
            'source' => $this->source,
            'montant' => $this->montant,
            'user_id' => $this->user
        ];

        if ($this->modelId) {
            Client::find($this->modelId)->update($data);
        } else {
            Client::create($data);
        }

        $this->dispatch('refreshParent');
        $this->dispatch('closeModal');
        $this->clearVars();
        Session()->flash('message', "Client ajouté avec succès !");
        return $this->redirect('/liste/de/client', navigate: true);
    }

   
    public function deletePost($id){
        Client::where('id',$id)->delete();
        Session()->flash('message', 'Client supprimé !');
        return $this->redirect('/liste/de/client', navigate: true);
    }

    private function clearVars(){
        $this->modelId = null;
        $this->code = null;
        $this->nom = null;
        $this->tel = null;
        $this->adresse = null;
        $this->source = null;
        $this->montant = null;
    }

    
    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId; 
        $this->action = $action; 

        if ($action === 'update') {
            $this->dispatch('getModelId', $this->selectedItem);
            $this->dispatch('openModal');
        } elseif ($action === 'delete') {
            $this->dispatch('openDeleteModal');
        }
    }

    public function mettreEnFavoris($id){
        try {
            $clientTrouver = Client::find($id);
            if(!$clientTrouver){
                session()->flash('message', 'Client non trouvé !');
            }
            //Ajouter dans clientFavoris maintenant
            $clientTrouver->statut = 1;
            $clientTrouver->save();
            Session()->flash('message', 'Client a été mis en favoris !');
            return $this->redirect('/liste/de/client', navigate: true);

        } catch (Exception $e) {
            Session()->flash('message', 'Quelque chose à mal tournée !'.$e->getMessage());
        }
    }

}
