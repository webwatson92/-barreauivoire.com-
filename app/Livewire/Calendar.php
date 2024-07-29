<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class Calendar extends Component
{
    public $events = [];

    /**
     * On peut modifier un événement en ajustant la fin
     */
    public function eventChange($event)
    {
        $e = Event::find($event['id']);
        $e->start = $event['start'];
        if(Arr::exists($event, 'end')) {
            $e->end = $event['end'];
        }
        $e->save();
    }

    /**
     * Ajouter un nouveau évènement
     */
    public function eventAdd($event)
    {
        Event::create($event);
    }

    /**
     * Suppression d'un event
     */
    public function eventRemove($id)
    {
        Event::destroy($id);
    }


    public function render()
    {
        $this->events = json_encode(Event::all());
        return view('livewire.calendar');
    }
}
