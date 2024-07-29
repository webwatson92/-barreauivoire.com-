<?php

namespace App\Livewire\Back\Client;

use Livewire\Component;
use App\Models\Client;
use Auth;

class EditionClient extends Component
{
    public Client $client;
    public $clientId;
    public $code, $nom, $adresse, $tel, $source, $montant;
    public $user;

    public function mount($clientInfo){
        $this->client = $clientInfo;
        $this->code = $clientInfo->code;
        $this->nom = $clientInfo->nom;
        $this->adresse = $clientInfo->adresse;
        $this->tel = $clientInfo->tel;
        $this->source = $clientInfo->source;
        $this->montant = $clientInfo->montant;
        $user = Auth::user()->id;
        $this->user = $user;
    }

    public function update(){
        // update data to database
        $this->validate([
            'nom' => 'required|string',
            'adresse' => 'required|string',
            'tel' => 'required|string|',
            'montant' => 'required|integer',
        ]);
    
        // $photo_name = md5($this->photo . microtime()).'.'.$this->photo->extension();
        // $this->photo->storeAs('public/images', $photo_name);
        Client::where('id',$this->client->id)->update([
            'code' => $this->code,
            'nom' => $this->nom,
            'adresse' => $this->adresse,
            'tel' => $this->tel,
            'source' => $this->source,
            'montant' => $this->montant,
            'user_id' => $this->user
        ]);

        session()->flash('message', 'Le client a été mis à jour!');
        return $this->redirect('/liste/de/client',navigate: true);
        
    }

    public function render()
    {
        return view('livewire.back.client.edition-client');
    }
}
