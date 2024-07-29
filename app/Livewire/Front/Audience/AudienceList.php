<?php

namespace App\Livewire\Front\Audience;

use Livewire\Component;
use App\Models\{Tribunal, Ville};

class AudienceList extends Component
{
    public function render()
    {
        $tribunaux = Tribunal::all();
        $villes = Ville::all();
        return view('livewire.front.audience.audience-list',  compact('tribunaux', 'villes'));
    }
}
