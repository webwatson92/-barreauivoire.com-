<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Conclusion, Statut, Parametre};
use Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ConclusionController extends Controller
{
    
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeConclusion(){
        $user_id = Auth::user()->id;
        return view('front.conclusion.listedeconclusion', compact('user_id'));
    }

    /**
     * Fonction pour charger la liste des Conclusion
     */
    public function chargerListeDeConclusion($user_id){
        $user = User::find($user_id);
    
        // Récupérer la liste des conclusion envoyés et reçus par cet utilisateur
        $conclusionEnvoyes = Conclusion::where('user_id', $user_id)->where('etat_qualificatif_id','!=', 5)->latest()->get();
        $conclusionRecus = Conclusion::where('user_id_2', $user_id)->latest()->get();
        // dd($conclusionEnvoyes);
        return Datatables::of($conclusionEnvoyes->merge($conclusionRecus))
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($conclusion) {
            $ok="";
            return '<button class="btn btn-danger btn-sm" wire.click="accuserReception()"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($conclusion) {
            return $conclusion->titre;
        })
        ->addColumn('nomfichier', function ($conclusion) {
            return $conclusion->nomfichier;
        })
        ->addColumn('date_cloture', function ($conclusion) {
            return $conclusion->date_cloture ? with(new Carbon($conclusion->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($conclusion) use ($user_id){
            if ($conclusion->user_id == $user_id) {
                $destinataireId = $conclusion->user_id_2;
            } else {
                $destinataireId = $conclusion->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($conclusion) use ($user_id) { 
            $etat = "";
            if($conclusion->user_id == $user_id){
                
                // if($conclusion->etat_qualificatif_id == 3){
                if($conclusion->estLuOuPas == 0){
                    $etat = "En attente de reception";
                }else if($conclusion->etat_qualificatif_id == 6){
                    $etat = "Traiter";
                }else if($conclusion->estLuOuPas == 1){
                    $etat = "courrier Lu";
                }
            }else{
                // if($conclusion->etat_qualificatif_id == 3){
                if($conclusion->estLuOuPas == 0){
                    $etat = "En attente de reception";
                }else if($conclusion->etat_qualificatif_id == 6){
                    $etat = "Traiter";
                }else if($conclusion->estLuOuPas == 1){
                    $etat = "Bien reçu";
                }
            }
            return $etat;
        })
        ->editColumn('action', function ($conclusion) use ($user_id) {
            $action = "";
            $contenu = base64_decode($conclusion->contenu); //recupérer la version avant sauvegarde
            if($conclusion->user_id == $user_id){//expediteur
                if($conclusion->estLuOuPas == 1){//estLu
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$conclusion->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                    ';
                }else{//nestpasLu
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$conclusion->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                        <button wire:click="deletePost('.$conclusion->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?" 
                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i></button>
                    ';
                }
            }else{//destinataire
                if($conclusion->estLuOuPas == 0){//estLu
                    $action = '
                        <button class="btn btn-success btn-sm" title="Accuser reception" wire:click="AccuserDeReceptionDuDossier('.$conclusion->id.')"><i class="fa-solid fa-check"></i>Accuser reception</button>
                    ';
                }else{
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$conclusion->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                    ';
                }
            }
            return $action;
        })
        ->rawColumns(['img_pdf', 'action'])
        ->make(true);

    }
    
    /**
     * Fonction pour charger la liste des conclusion lu
     */
    public function chargerListeDeConclusionLu($user_id){
        $user = User::find($user_id);
        
        // Récupérer la liste des conclusion envoyés et reçus par cet utilisateur
        $conclusionEnvoyes = Conclusion::where('user_id', $user_id)->where('estLuOuPas', 1)->get();
        $conclusionRecus = Conclusion::where('user_id_2', $user_id)->where('estLuOuPas', 1)->get();

        
        return Datatables::of($conclusionEnvoyes->merge($conclusionRecus))
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($conclusion) {
            $ok="";
            return '<button class="btn btn-danger btn-sm"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($conclusion) {
            return $conclusion->titre;
        })
        ->addColumn('nomfichier', function ($conclusion) {
            return $conclusion->nomfichier;
        })
        ->addColumn('date_cloture', function ($conclusion) {
            return $conclusion->date_cloture ? with(new Carbon($conclusion->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($conclusion) use ($user_id){
            if ($conclusion->user_id == $user_id) {
                $destinataireId = $conclusion->user_id_2;
            } else {
                $destinataireId = $conclusion->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($conclusion) use ($user_id) { 
            $etat = "";
            if($conclusion->user_id == $user_id){//celui qui envoi le courrier
                $etat = "courrier lu par la source";
            }else{// celui qui reçu
                $etat = "courrier lu";
            }
            return $etat;
        })
        ->rawColumns(['img_pdf'])
        ->make(true);
    }

    /**
     * Fonction pour charger la liste des conclusion envoyer
     */
    public function chargerListeDeConclusionEnvoyer($user_id){
        $user = User::find($user_id);
        
        // Récupérer la liste des conclusion envoyés et reçus par cet utilisateur
        $conclusionEnvoyes = Conclusion::where('user_id', $user_id)->where('etat_qualificatif_id', 3)->get();

        return Datatables::of($conclusionEnvoyes)
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($conclusion) {
            $ok="";
            return '<button class="btn btn-danger btn-sm"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($conclusion) {
            return $conclusion->titre;
        })
        ->addColumn('nomfichier', function ($conclusion) {
            return $conclusion->nomfichier;
        })
        ->addColumn('date_cloture', function ($conclusion) {
            return $conclusion->date_cloture ? with(new Carbon($conclusion->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($conclusion) use ($user_id){
            if ($conclusion->user_id == $user_id) {
                $destinataireId = $conclusion->user_id_2;
            } else {
                $destinataireId = $conclusion->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($conclusion) use ($user_id) { 
            $etat = "";
            if($conclusion->user_id == $user_id){//expediteur
                $etat = $conclusion->estLuOuPas == 0 ? "En attente de reception" : "Envoyé";
            }else{
                $etat = $conclusion->estLuOuPas == 0 ? "Dossier à receptionner" : "Reçu";
            }
            return $etat;
        })
        ->editColumn('action', function ($conclusion) use ($user_id) {
            $action = "";
            if($conclusion->user_id == $user_id){//expediteur
                $action = '
                        <button class="btn btn-danger btn-sm" title="Annuler envoi" wire:click="AnnulerEnvoiDuDossier('.$conclusion->id.')"><i class="fa-solid fa-thumbs-down"></i></button>
                ';
            }
            return $action;
        })
        ->rawColumns(['img_pdf', 'action'])
        ->make(true);
    }

    /**
     * Fonction pour l'affichage de la vue de modification
     */
    public function vueEditionConclusion($conclusionId){
        $conclusionInfo = Conclusion::find(courrierId);
        //dd($conclusionInfo);
        $statuts = Statut::all();
        if ($conclusionInfo !== null) {
            return view('front.conclusion.editionconclusion', compact('conclusionInfo', 'statuts'));
        } 
    }

    /**
     * Envoyer un docuement
     */
    public function vueEnvoyerConclusion(){
        $statuts = Statut::all();
        return view('front.conclusion.envoideconclusion', compact('statuts'));
    }

    
    /**
     * Validation de l'envoi en post
     */
    public function envoyerConclusion(Request $request){
        // dd($request->titre);
        $request->validate([
            'titre' => 'required|string',
            // 'contenu' => 'required|mimes:pdf|max:2048',
            'date_cloture' => 'required|date',
            'pertinance' => 'required|string',
            'destinataire_id' => 'required',
        ]);
        
        if ($request->hasFile('contenu')) {
            // Obtenir le contenu du fichier PDF
            $contenu = file_get_contents($request->file('contenu')->path());
            $base64Data = base64_encode($contenu);
            // Obtenez le nom du fichier
            $nomFichier = Parametre::genererNomDuFichier($request->titre);//1
            // dd($nomFichier);
            // Générer l'empreinte numérique avec la fonction MD5
            $empreinte = Parametre::genererEmpreinte($contenu);//2
            // Récupérer une empreinte existante
            $existe = Parametre::verifierSiEmpreinteExiste($empreinte);//2
            if($existe ===false){
                $conclusion = new Conclusion();
                $conclusion->titre = $request->titre;
                $conclusion->nomfichier = $nomFichier;
                $conclusion->contenu = $base64Data;
                $conclusion->empreinte_fichier = $empreinte;
                $conclusion->date_cloture = $request->date_cloture;
                $conclusion->etat_qualificatif_id = 3;
                $conclusion->user_id = auth()->id();

                // Récupérer le destinataire
                $destinataire = User::find($request->destinataire_id);
                
                $conclusion->user_id_2 = $destinataire->id;
                $conclusion->pertinance = $request->pertinance;

                $conclusion->save();
                Parametre::sauvegarderTampon($empreinte);//4
                $request->replace([
                    'matricule' => '',
                    'titre' => '',
                    'nomfichier' => '',
                    'contenu' => '',
                    'date_cloture' => '',
                    'nomComplet' => '',
                ]);
            
                session()->flash('message', "Conclusion envoyé avec succès !");
                return redirect()->route('vue.liste.conclusion');
            }
            return redirect()->back()->with('warning', 'La conclusion existe déjà dans la base de données.');
        } else {
            // Gérer le cas où aucun fichier n'a été téléchargé
            return redirect()->back()->withInput()->withErrors(['contenu' => 'Veuillez sélectionner un fichier.']);
        }

    }

    /**
     * Modification du courrier
     */
    public function modifierConclusion(Request $request){
        // dd($request);
        $request->validate([
            'titre' => 'required|string',
            // 'contenu' => 'required|mimes:pdf|max:2048',
            'date_cloture' => 'required|date',
            'pertinance' => 'required|string',
            
        ]);
        
        if ($request->hasFile('contenu')) {
            // Obtenir le contenu du fichier PDF
            $contenu = file_get_contents($request->file('contenu')->path());
            $base64Data = base64_encode($contenu);
            $nomFichier = $request->file('contenu')->getClientOriginalName();
        } else {
            return redirect()->back()->withInput()->withErrors(['contenu' => 'Veuillez sélectionner un fichier.']);
        }

        $conclusionTrouver = Conclusion::find($request->courrierId);
        // dd(courrierTrouver);
        $conclusionTrouver->titre = $request->titre;
        $conclusionTrouver->nomfichier = $nomFichier;
        $conclusionTrouver->contenu = $base64Data;
        $conclusionTrouver->date_cloture = $request->date_cloture;
        $conclusionTrouver->etat_qualificatif_id = 3;
        $conclusionTrouver->user_id = auth()->id();

        // Récupérer le destinataire
        $destinataireTrouver = User::find($request->destinataire_id);
        $conclusionTrouver->user_id_2 = $destinataireTrouver->id;
        $conclusionTrouver->pertinance = $request->pertinance;
        // dd(courrier);
        $conclusionTrouver->save();
        
        $request->replace([
            'nomfichier' => '',
            'contenu' => '',
            'date_cloture' => '',
            'pertinance' => '',
        ]);
    
        session()->flash('message', "Conclusion envoyé avec succès !");
        return redirect('liste/de/conclusion');
    }
    
}
