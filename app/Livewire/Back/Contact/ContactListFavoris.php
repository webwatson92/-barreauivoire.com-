<?php

namespace App\Livewire\Back\Contact;

use Livewire\Component;
use App\Models\{Contact, FavorisContact};
use Auth;
use Session;

class ContactListFavoris extends Component
{
    public $search;
    public $rechercheContact;

    public function mount($search = null)
    {
        $this->search = $search;
        $this->rechercheContact = null;
    }
    
    public function retirerEnFavoris($id){
        try {
            $contactFavoris = FavorisContact::find($id)->delete();
        
            if(!$contactFavoris){
                session()->flash('message', "Ce contact n'est pas en favoris!");
            }
            
            Session()->flash('message', 'Contact a retiré de votre favoris !');
            return $this->redirect('/liste/de/contact', navigate: true);

        } catch (Exception $e) {
            Session()->flash('message', 'Quelque chose à mal tournée !'.$e->getMessage());
        }
    }
    
    public function recherche()
    {
        $rechercheContact = Contact::find($this->search);
        if (!$rechercheContact) {
            Session::flash('message', "Aucun contact trouvé");
            return redirect()->back();
        }
        $this->rechercheContact = $rechercheContact; 
        return view('livewire.back.contact.contact-list-favoris')->layout('layouts.base');
    }


    public function render()
    {
        $rechercheContact = null; 
        $contactFavoris = FavorisContact::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(9);
        return view('livewire.back.contact.contact-list-favoris',compact('contactFavoris', 'rechercheContact'))->layout('layouts.base');
    }
}
