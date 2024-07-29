<?php

namespace App\Livewire\Back\Contact;

use Livewire\Component;
use App\Models\Contact;
use Session;

class EditionContact extends Component
{
    public Contact $contact;
    public $contactId;
    public $nom;
    public $tel;
    public $email;

    public function mount($contactInfo){
        $this->contact = $contactInfo;
        $this->nom = $contactInfo->nom;
        $this->tel = $contactInfo->tel;
        $this->email = $contactInfo->email;
    }

    public function update(){
        // update data to database
        $this->validate([
            'nom' => 'required',
            'tel' => 'required',
            'email' => 'required',
        ]);
    
        // $photo_name = md5($this->photo . microtime()).'.'.$this->photo->extension();
        // $this->photo->storeAs('public/images', $photo_name);
        Contact::where('id',$this->contact->id)->update([
            'nom' => $this->nom,
            'tel' => $this->tel,
            'email' => $this->email
        ]);

        session()->flash('message', 'Le contact a été mis à jour!');
        return $this->redirect('/liste/de/contact',navigate: true);
        
    }

    public function render()
    {
        return view('livewire.back.contact.edition-contact');
    }
}
