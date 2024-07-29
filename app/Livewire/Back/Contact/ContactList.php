<?php

namespace App\Livewire\Back\Contact;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Contact, FavorisContact};
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Session;
use Auth;

class ContactList extends Component
{
    use WithPagination;
    public $nom;
    public $tel;
    public $email;

    public function save()
    {
        $this->validate([
            'nom' => "required|string",
            'tel' => "required|string",
            'email' => "required|string",
        ]);

        $data = [
            'nom' => $this->nom,
            'tel' => $this->tel,
            'email' => $this->email,
        ];

        Contact::create($data);
        Session()->flash('message', "Contact ajouté avec succès !");
        return $this->redirect('/liste/de/contact', navigate: true);
    }

    public function deletePost($id){
        Contact::where('id',$id)->delete();
        Session()->flash('message', 'Contact supprimé !');
        return $this->redirect('/liste/de/contact', navigate: true);
    }

    public function mettreEnFavoris($id){
        try {
            $contactTrouver = User::find($id);
            dd($contactTrouver);
            $contactFavoris = FavorisContact::where('user_id', Auth::user()->id)->get();
            foreach($contactFavoris as $favoris){
                if($favoris->nom == $contactTrouver->nom){
                    session()->flash('message', 'Ce contact existe déjà dans votre liste de favoris !');
                    return $this->redirect('/liste/de/contact', navigate: true);
                }
            }
        
            if(!$contactTrouver){
                session()->flash('message', 'Contact non trouvé !');
            }
            //Ajouter dans contactFavoris maintenant
            $contactFavoris = new FavorisContact();
            $contactFavoris->nom = $contactTrouver->nom .' '. $contactTrouver->prenom;
            $contactFavoris->tel = $contactTrouver->tel;
            $contactFavoris->user_id = Auth::user()->id;
            $contactFavoris->save();
            Session()->flash('message', 'Contact a été mis en favoris !');
            return $this->redirect('/liste/de/contact', navigate: true);

        } catch (Exception $e) {
            Session()->flash('message', 'Quelque chose à mal tournée !'.$e->getMessage());
        }
    }

    

    public function render(): View
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(5);
        // dd($contacts);
        return view('livewire.back.contact.contact-list',compact('contacts'))->layout('layouts.base');
    }
    
}
