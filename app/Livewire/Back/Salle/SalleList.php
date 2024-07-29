<?php

namespace App\Livewire\Back\Salle;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Salle;
use Auth;
use Carbon\Carbon;

class SalleList extends Component
{
    use WithFileUploads;
    public $image, $nom, $description, $etat_qualificatif_id, $cout, $lieu, $capacite, $newimage;

    public function save()
    {
        $this->validate([
            'image.*'=> 'mimes:png, jpeg, jpg',
            'nom' => "required|string",
            'description' => "string|min:10",
            'capacite' => "required|string|min:10",
            'lieu' => "string|required",
            'cout' => "required|integer",
            'etat_qualificatif_id' => "required|integer"
        ]);

        // dd($this->image);
        $salle = new Salle();
        
        if($this->image){
            $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
            $this->image->storeAs('salles', $imageName);
            $salle->image = $imageName;
        }
        $salle->nom = $request->nom;
        $salle->description = $request->description;
        $salle->capacite = $request->capacite;
        $salle->lieu = $request->lieu;
        $salle->cout = $request->cout;
        $salle->etat_qualificatif_id = $request->etat_qualificatif_id;
        $salle->user_id = Auth::user()->id;

        $salle->save();
        Session()->flash('message', "Salle ajouté avec succès !");
        return $this->redirect('/liste/de/salle', navigate: true);
    }

    public function deletePost($id){
        Salle::where('id',$id)->delete();
        session()->flash('message', 'Salle supprimé !');
        return $this->redirect('/liste/de/salle', navigate: true);
    }


    public function render()
    {
        return view('livewire.back.salle.salle-list');
    }
}
