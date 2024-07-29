<?php

namespace App\Livewire\Front\Audience;

use Livewire\Component;
use App\Models\{Tribunal, Ville, Audience};
use Carbon\Carbon;

class Recherche extends Component
{
    public $villes, $tribunaux, $audiences, $ville_id, $date_conseil, $tribunal_id, $heure, $query;

    public function mount()
    {
        $this->villes = Ville::all();
        $this->tribunaux = Tribunal::all();
        $this->audiences = Audience::all();
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'ville_id' => 'required',
            'date_conseil' => 'required',
            'tribunal_id' => 'required',
        ]);

        $this->search();
    }

    public function search()
    {
        $query = Audience::query();
        // dd($query);
        if ($this->ville_id) {
           
            $query->where('ville_id', $this->ville_id);
        }

        if ($this->date_conseil) {
            $query->whereDate('date_conseil', Carbon::parse($this->date_conseil)->format('Y-m-d'));
        }

        if ($this->tribunal_id) {
            $query->where('tribunal_id', $this->tribunal_id);
        }

        if ($this->heure) {
            [$heure_debut, $heure_fin] = explode('-', $this->heure);
            $query->whereTime('heure_debut', '>=', $heure_debut)
                  ->whereTime('heure_fin', '<=', $heure_fin);
        }

        $this->audiences = $query->get();
    }

    public function render()
    {  
        $tribunaux = Tribunal::all();
        $villes = Ville::all();
        $audiences = Audience::all();
        return view('livewire.front.audience.recherche', compact('tribunaux', 'villes', 'audiences'));
    }
}
