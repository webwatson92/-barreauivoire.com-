<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Auth;
use DataTables;

class ClientController extends Controller
{
    
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeClient(){
        return view('front.client.listedeclient');
    }

    public function vueEditionClient($clientId){
        $clientInfo = Client::find($clientId);
        if ($clientInfo !== null) {
            return view('front.client.edition', compact('clientInfo'));
        } 
    }

    /**
     * Fonction pour charger la liste des clients
     */
    public function chargerListeDeClient(){
        $client = Client::where('statut', 0)->orderBy('created_at', 'desc');
        
        return Datatables::of($client)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('code', function ($client) {
                return $client->code;
            })
            ->addColumn('nom', function ($client) {
                return $client->nom;
            })
            ->addColumn('adresse', function ($client) {
                return $client->adresse;
            })
            ->addColumn('tel', function ($client) {
                return $client->tel;
            })
            ->addColumn('source', function ($client) {
                return $client->source;
            })
            ->addColumn('montant', function ($client) {
                return $client->montant;
            })
            ->editColumn('action', function ($client) {
                return '
                <a href="/edition/client/'.$client->id.'" wire:navigate class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil fa-fw"></i></a>
                <button class="btn bt-sm btn-danger" wire:click="deletePost('.$client->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?">
                    <i class="fa-solid fa-trash fa-fw"></i>
                </button>
                <button wire:click="mettreEnFavoris('.$client->id.')" class="btn btn-succes btn-sm"><i class="fa-regular fa-star"></i></button>
                ';
            })
        ->rawColumns(['code', 'nom', 'adresse', 'tel', 'source', 'montant','action'])
        ->make(true);

    }

    /**
     * Fonction pour charger la liste des clients mis en favoris par un avocat ou Editer Avocat
     */
    public function chargerListeDeClientFavoris(){
        $clientFavoris = Client::where('statut', 1)->orderBy('created_at', 'desc');
        
        return Datatables::of($clientFavoris)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('code', function ($clientFavoris) {
                return $clientFavoris->code;
            })
            ->addColumn('nom', function ($clientFavoris) {
                return $clientFavoris->nom;
            })
            ->addColumn('adresse', function ($clientFavoris) {
                return $clientFavoris->adresse;
            })
            ->addColumn('tel', function ($clientFavoris) {
                return $clientFavoris->tel;
            })
            ->addColumn('source', function ($clientFavoris) {
                return $clientFavoris->source;
            })
            ->addColumn('montant', function ($clientFavoris) {
                return $clientFavoris->montant;
            })
            ->editColumn('action', function ($clientFavoris) {
                return '
                <a href="/edition/client/'.$clientFavoris->id.'" wire:navigate class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil fa-fw"></i></a>
                <button class="btn bt-sm btn-danger" wire:click="deletePost('.$clientFavoris->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?">
                    <i class="fa-solid fa-trash fa-fw"></i>
                </button>
                <button wire:click="retirerEnFavoris('.$clientFavoris->id.')" class="btn btn-succes btn-sm"><i class="fa-solid fa-star"></i></button>
                ';
            })
        ->rawColumns(['code', 'nom', 'adresse', 'tel', 'source', 'montant','action'])
        ->make(true);
    }

}
