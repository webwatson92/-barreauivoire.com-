<?php

namespace App\Livewire\Back\Tribunal;

use Livewire\Component;
use App\Models\{Ville, Tribunal};

class TribunalList extends Component
{
    public function render()
    {
        $villes = Ville::all();
        return view('livewire.back.tribunal.tribunal-list', compact("villes"));
    }
}
