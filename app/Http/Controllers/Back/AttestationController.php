<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EnvoyerAttestationRequest;
use App\Models\{DemandeAttestation, Attestation};
use Illuminate\Support\Facades\Mail;
use App\Mail\AttestationMail;


class AttestationController extends Controller
{   
    
    
    /**Affichage du formulaire d'envoi */
    public function vueEnvoyerAttestation($id){
        $demande = DemandeAttestation::findOrFail($id);
        // dd($demande);
        return view('front.attestation.vue-envoi-attestation', compact('demande'));
    }

    /**Fonction pour l'envoi de l'attestation */
    public function envoyerAttestation(EnvoyerAttestationRequest $request){
        $nomFichier = $request->nomFichier;
        $contenuFichier = $request->contenu;
        $demande = DemandeAttestation::findOrFail($request->demandeid);
        
        
        $nomFichierGenerer = str_replace(" ", "_", $nomFichier) .'.pdf';
        if ($request->hasFile('contenu')) {
            // Obtenir le contenu du fichier PDF
            $contenu = file_get_contents($request->file('contenu')->path());
            $contenuFichierCoder = base64_encode($contenu);
            $empreinte = md5($contenuFichierCoder);
            
            $demandeExiste = Attestation::where('empreinte', $empreinte)->first();
            $empreinteDemandeExiste = !is_null($demandeExiste) ? $demandeExiste->empreinte : null;
            if(!empty($empreinteDemandeExiste) != $empreinte){
                // dd( $empreinteDemandeExiste);
                $attestation = new Attestation();
                $attestation->nomFichier = $nomFichierGenerer;
                $attestation->contenu = $contenuFichierCoder;
                $attestation->empreinte = $empreinte;
                $attestation->demande_attestation_id = $request->demandeid;
                $attestation->save();

                // dd($demande->user->email);
                //Envoi de mail au destinataire
                Mail::to($demande->user->email)->send(new AttestationMail($attestation));

                Session()->flash('message', "Attestation envoyé avec succès");
                return redirect()->route('vue.liste.demande.attestation');
            }
            
            Session()->flash('message', "Le document existe déjà, choisissez-en un autre");
            return redirect()->back()->with('Le document existe déjà, choisissez-en un autre');
        } else {
            // Gérer le cas où aucun fichier n'a été téléchargé
            return redirect()->back()->withInput()->withErrors(['contenu' => 'Veuillez sélectionner un fichier.']);
        }

        return view('front.attestation.vue-envoi-attestation', compact('demande'));
    }

}
