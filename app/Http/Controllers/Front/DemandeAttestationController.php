<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, DemandeAttestation, Attestation};

use Auth;
use DataTables;
use Carbon\Carbon;

class DemandeAttestationController extends Controller
{
    
    /**
     * Vue pour la page de demande des attestations
     */
    public function vueDemandeAttestation(){
        return view("front.demande_attestation.demander");
    }

    /**
     * Vue pour la liste des demandes en cour ou en attente de validation par l'admin ou par le barreau
     */
    public function vueListeDemandeAttestation(){
        $user = User::where('role', Auth::user()->role)->first();
        // dd($user);
        $userId = $user->id;
        return view("front.demande_attestation.listededemande", compact('userId', 'user'));
    }

    /**
     * Vue pour le chargement de la liste des demandes en cour ou en attente de validation par l'admin ou par le barreau
     */
    public function chargerListeDeDemandeAttestation($user_id)
    {
        $index = 0;
        $demandesTrouver = DemandeAttestation::where('user_id', Auth::user()->id)->latest()->get();

        // dd($demandesTrouver);
        return Datatables::of($demandesTrouver)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('date_demande', function ($demande) {
                
                return $demande->date_demande ? with(new Carbon($demande->date_demande))->diffForHumans() : '';
            })
            ->addColumn('etat', function ($demande){ 
                $etat = "";  
                if($demande->etat_qualificatif_id == 3){
                    $etat = "En attente de validation";
                }elseif($demande->etat_qualificatif_id == 4){ 
                    $etat = "Rejeter";
                }elseif($demande->etat_qualificatif_id == 2){ 
                    $etat = "Valider";
                }else {
                    $etat = "Validersss";
                }
                return $etat;
            })
            ->editColumn('action', function ($demande){
                $action =""; //$demande->id
                $attestationExistante = Attestation::where('demande_attestation_id', $demande->id)->first();
                $contenu = !is_null($attestationExistante) ? base64_decode($attestationExistante->contenu) : "";
                if($demande->etat_qualificatif_id == 3){
                    $action = '
                        <button wire:click="deletePost('.$demande->id.')" wire:confirm="Etes-vous sûre de vouloir annuler la demande ?" 
                                class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i> Annuler</button>
                    ';
                }else{
                    //si l'admin envoi l'attestation
                    $attestationExistante = Attestation::where('demande_attestation_id', $demande->id)->exists();
                    // dd($attestationExistante);
                    if($attestationExistante){
                        $action = '
                            <button class="btn btn-success btn-sm">Déjà validé</button>
                            <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="attestation_mon_barreau.pdf"><i class="fa-solid fa-download"></i></a>
                        ';
                    }else{
                        $action = '
                            <button class="btn btn-success btn-sm">Reçu par le barreau</button>
                        ';
                    }
                    
                    
                }
                
                return $action;
            })
            ->rawColumns(['date_demande', 'etat', 'action'])
            ->make(true);
    
    }

    
    public function chargerListeDeDemandeAttestationAdmin($demandeId){
        $index = 0;
        $demandesTrouver = DemandeAttestation::all();
        $attestationEnvoyerEstTrouver = Attestation::all();
        return Datatables::of($demandesTrouver)
        ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('date_demande', function ($demande) {
                return $demande->date_demande ? with(new Carbon($demande->date_demande))->diffForHumans() : '';
            })
            ->addColumn('etat', function ($demande){ 
                $etat = "";  
                if($demande->etat_qualificatif_id == 3){
                    $etat = "En attente de validation";
                } else {
                    $etat = "Validé";
                }
                return $etat;
            })
            ->editColumn('action', function ($demande) {
                $action ="";
                if($demande->etat_qualificatif_id == 3){
                    $action = '
                        <button wire:click="validerDemande('.$demande->id.')" 
                                class="btn btn-success btn-sm"><i class="fa-solid fa-square-check"></i> Valider</button>
                        <button wire:click="rejeterDemande('.$demande->id.')"  
                                class="btn btn-danger btn-sm"><i class="fa-solid fa-thumbs-down"></i> Rejeter</button>
                    ';
                }elseif($demande->etat_qualificatif_id == 4){
                    $action = '
                        <button class="btn btn-danger btn-sm">Rejeter</button>
                    ';
                }else{
                    // Vérifier si une attestation existe pour cette demande
                    $attestationExistante = Attestation::where('demande_attestation_id', $demande->id)->exists();

                    // Afficher le bouton "Envoyer" seulement si aucune attestation existe
                    if (!$attestationExistante) {
                        return '
                            <button class="btn btn-success btn-sm">Valider</button>
                            <a class="btn btn-primary" href="/envoi/du/attestation/' . $demande->id . '" wire:navigate><i class="fa-solid fa-share-from-square"></i> Envoyer</a>
                        ';
                    } else {
                        return '<button class="btn btn-success btn-sm disabled" disabled>Attestation envoyée</button>';
                    }
                }
                
                return $action;
            })
            ->rawColumns(['date_demande', 'etat', 'action'])
            ->make(true);
    
    }
    
    /**
     * Vue pour l'affichage du formulaire d'envoi de l'attestation
     */
    // public function voirAttestation($id)
    // {
    //     $attestation = Attestation::findOrFail($id);
    //     return response()->file(storage_path('app/' . $attestation->pdf_path));
    // }
}
