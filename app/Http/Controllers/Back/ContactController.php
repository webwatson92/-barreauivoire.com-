<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Contact, FavorisContact};
use DataTables;
use Auth;

class ContactController extends Controller
{
   
    /**
     * Affichage de la liste des contacts de chaque membre de l'application
     */
    public function vueListeDeContact(){
        return view('front.contacts.listedecontact');
    }

    public function vueEditionContact($contactId){
        $contactInfo = Contact::find($contactId);
        if ($contactInfo !== null) {
            return view('front.contacts.edition', compact('contactInfo'));
        } 
        // else {
        // return view('front.contacts.edition', compact('contactInfo'));
    }

    public function chargerListeDeContact(){
        $roleUtilisateurConnecter = "";
        $contact = User::where('role', '!=', 'admin')->where('role', '!=', 'superadmin')->orderBy('created_at', 'desc');
        // dd($contact);
        return Datatables::of($contact)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('nom', function ($contact) {
                return $contact->name.' '.$contact->prenom;
            })
            ->addColumn('matricule', function ($contact) {
                return $contact->matricule;
            })
            ->addColumn('tel', function ($contact) {
                return $contact->telephone;
            })
            ->addColumn('email', function ($contact) {
                return $contact->email ?? "Pas renseigné";
            })
            // ->editColumn('action', function ($contact) {
            //     $roleUtilisateurConnecter = Auth::user()->role;
            //     return $roleUtilisateurConnecter == "admin" ||  $roleUtilisateurConnecter == "superadmin" ||  $roleUtilisateurConnecter == "barreau" 
            //         ? ' 
            //         <a href="/edition/contact/'.$contact->id.'" wire:navigate class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil fa-fw"></i></a>
            //         <button wire:click="deletePost('.$contact->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?" 
            //         class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i></button>' 
            //         : '
            //         <button wire:click="mettreEnFavoris('.$contact->id.')" class="btn btn-succes btn-lg"><i class="fa-regular fa-star"></i></button>
            //     ';
            // })
        ->rawColumns(['nom', 'matricule', 'tel'])
        ->make(true);
    }
    
    public function chargerListeDeContactFavoris(){
        $contactFavoris = FavorisContact::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        $roleUtilisateurConnecter = "";
        // dd($contact);
        return Datatables::of($contactFavoris)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('nom', function ($contactFavoris) {
                return $contactFavoris->name;
            })
            ->addColumn('matricule', function ($contactFavoris) {
                return $contactFavoris->matricule;
            })
            ->addColumn('tel', function ($contactFavoris) {
                return $contactFavoris->tel;
            })
            ->addColumn('email', function ($contactFavoris) {
                return $contactFavoris->email ?? "Pas renseigné";
            })
            ->editColumn('action', function ($contactFavoris) {
                return '<button wire:click="retirerEnFavoris('.$contactFavoris->id.')" class="btn btn-succes btn-lg"><i class="fa-solid fa-star"></i></button>
                ';
            })
        ->rawColumns(['nom', 'matricule', 'tel', 'action'])
        ->make(true);
    }

}
