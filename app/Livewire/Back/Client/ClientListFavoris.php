<?php

namespace App\Livewire\Back\Client;

use Livewire\Component;
use App\Models\Client;

class ClientListFavoris extends Component
{
    public function render()
    {
        return view('livewire.back.client.client-list-favoris');
    }

    public function retirerEnFavoris($id){
        try {
            $clientTrouver = Client::find($id);
            if(!$clientTrouver){
                session()->flash('message', 'Client non trouvé !');
            }
            //Ajouter dans clientFavoris maintenant
            $clientTrouver->statut = 0;
            $clientTrouver->save();
            Session()->flash('message', 'Client a été rétiré de votre favoris !');
            return $this->redirect('/liste/de/client', navigate: true);

        } catch (Exception $e) {
            Session()->flash('message', 'Quelque chose à mal tournée !'.$e->getMessage());
        }
    }
}
