<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Document, Statut, Parametre};
use Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Log;

class DocumentController extends Controller
{
   
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeDocument(){
        $user_id = Auth::user()->id;
        return view('front.document.listededocument', compact('user_id'));
    }

    /**
     * Fonction pour charger la liste des documents
     */
    public function chargerListeDeDocument($user_id){
        $user = User::find($user_id);
    
        // Récupérer la liste des documents envoyés et reçus par cet utilisateur
        $documentsEnvoyes = Document::where('user_id', $user_id)->where('etat_qualificatif_id','!=', 5)->latest()->get();
        $documentsRecus = Document::where('user_id_2', $user_id)->latest()->get();
       
        return Datatables::of($documentsEnvoyes->merge($documentsRecus))
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($document) {
            $ok="";
            return '<button class="btn btn-danger btn-sm" wire.click="accuserReception()"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($document) {
            return $document->titre;
        })
        ->addColumn('nomfichier', function ($document) {
            return $document->nomfichier;
        })
        ->addColumn('date_cloture', function ($document) {
            return $document->date_cloture ? with(new Carbon($document->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($document) use ($user_id){
            if ($document->user_id == $user_id) {
                $destinataireId = $document->user_id_2;
            } else {
                $destinataireId = $document->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($document) use ($user_id) { 
            $etat = "";
            if($document->user_id == $user_id){
                
                // if($document->etat_qualificatif_id == 3){
                if($document->estLuOuPas == 0){
                    $etat = "En attente de reception";
                    
                }else if($document->etat_qualificatif_id == 6){
                    $etat = "Traiter";
                    
                }else if($document->estLuOuPas == 1){
                    $etat = "Document Lu";
                    
                }
            }else{
                // if($document->etat_qualificatif_id == 3){
                if($document->estLuOuPas == 0){
                    $etat = "En attente de reception";
                    
                }else if($document->etat_qualificatif_id == 6){
                    $etat = "Traiter";
                }else if($document->estLuOuPas == 1){
                    $etat = "Bien reçu";
                }
            }
            Log::info('Document Etat: ', ['etat' => $etat]);
            return $etat;
        })
        ->editColumn('action', function ($document) use ($user_id) {
            $action = "";
            $contenu = base64_decode($document->contenu); //recupérer la version avant sauvegarde
            if($document->user_id == $user_id){//expediteur
                if($document->estLuOuPas == 1){//estLu
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$document->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                    ';
                }else{//nestpasLu
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$document->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                        <button wire:click="deletePost('.$document->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?" 
                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i></button>
                    ';
                }
            }else{//destinataire
                if($document->estLuOuPas == 0){//estLu
                    $action = '
                        <button class="btn btn-success btn-sm" title="Accuser reception" wire:click="AccuserDeReceptionDuDossier('.$document->id.')"><i class="fa-solid fa-check"></i>Accuser reception</button>
                    ';
                }else{
                    $action = '
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).'" download="'.$document->nomfichier.'"><i class="fa-solid fa-download"></i></a>
                    ';
                }
            }
            return $action;
        })
        ->rawColumns(['img_pdf', 'action'])
        ->make(true);

    }
    
    /**
     * Fonction pour charger la liste des documents lu
     */
    public function chargerListeDeDocumentLu($user_id){
        $user = User::find($user_id);
        
        // Récupérer la liste des documents envoyés et reçus par cet utilisateur
        $documentsEnvoyes = Document::where('user_id', $user_id)->where('estLuOuPas', 1)->get();
        $documentsRecus = Document::where('user_id_2', $user_id)->where('estLuOuPas', 1)->get();

        
        return Datatables::of($documentsEnvoyes->merge($documentsRecus))
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($document) {
            $ok="";
            return '<button class="btn btn-danger btn-sm"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($document) {
            return $document->titre;
        })
        ->addColumn('nomfichier', function ($document) {
            return $document->nomfichier;
        })
        ->addColumn('date_cloture', function ($document) {
            return $document->date_cloture ? with(new Carbon($document->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($document) use ($user_id){
            if ($document->user_id == $user_id) {
                $destinataireId = $document->user_id_2;
            } else {
                $destinataireId = $document->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($document) use ($user_id) { 
            $etat = "";
            if($document->user_id == $user_id){//celui qui envoi le document
                $etat = "Document lu par la source";
            }else{// celui qui reçu
                $etat = "Document lu";
            }
            return $etat;
        })
        ->rawColumns(['img_pdf'])
        ->make(true);
    }

    /**
     * Fonction pour charger la liste des documents envoyer
     */
    public function chargerListeDeDocumentEnvoyer($user_id){
        $user = User::find($user_id);
        
        // Récupérer la liste des documents envoyés et reçus par cet utilisateur
        $documentsEnvoyes = Document::where('user_id', $user_id)->where('etat_qualificatif_id', 3)->get();

        return Datatables::of($documentsEnvoyes)
        ->addColumn('numero', function () use (&$index) {
            $index++;
            return $index;
        })
        ->addColumn('img_pdf', function ($document) {
            $ok="";
            return '<button class="btn btn-danger btn-sm"><i class="fa-solid fa-file-pdf"></i></button>';
        })
        ->addColumn('titre', function ($document) {
            return $document->titre;
        })
        ->addColumn('nomfichier', function ($document) {
            return $document->nomfichier;
        })
        ->addColumn('date_cloture', function ($document) {
            return $document->date_cloture ? with(new Carbon($document->date_cloture))->format('d/m/Y') : '';
        })
        ->addColumn('destinataire', function ($document) use ($user_id){
            if ($document->user_id == $user_id) {
                $destinataireId = $document->user_id_2;
            } else {
                $destinataireId = $document->user_id;
            }
            $destinataire = User::find($destinataireId);
            return $destinataire->name.' '.$destinataire->prenom;
        })
        ->addColumn('etat', function ($document) use ($user_id) { 
            $etat = "";
            if($document->user_id == $user_id){//expediteur
                $etat = $document->estLuOuPas == 0 ? "En attente de reception" : "Envoyé";
            }else{
                $etat = $document->estLuOuPas == 0 ? "Dossier à receptionner" : "Reçu";
            }
            return $etat;
        })
        ->editColumn('action', function ($document) use ($user_id) {
            $action = "";
            if($document->user_id == $user_id){//expediteur
                $action = '
                        <button class="btn btn-danger btn-sm" title="Annuler envoi" wire:click="AnnulerEnvoiDuDossier('.$document->id.')"><i class="fa-solid fa-thumbs-down"></i></button>
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
    public function vueEditionDocument($documentId){
        $documentInfo = Document::find($documentId);
        //dd($documentInfo);
        $statuts = Statut::all();
        if ($documentInfo !== null) {
            return view('front.document.edition', compact('documentInfo', 'statuts'));
        } 
    }

    /**
     * Envoyer un docuement
     */
    public function vueEnvoyerDocument(){
        $statuts = Statut::all();
        return view('front.document.envoidedocument', compact('statuts'));
    }

    /**
     * Chargement et recherche du nom complet en fonction du matricule
     */
    public function chargerLeNomEtLePrenom($matricule){
        $user = User::where('matricule', $matricule)->first();
        // dd($user->id);
        if ($user) {
            return response()->json([
                'nom' => $user->name,
                'prenom' => $user->prenom,
                'destinataire_id'=> $user->id,
            ]);
        } else {
            // document.window = "/envoyer/un/document";
            return response()->json(['error' => 'Utilisateur non trouvé.'], 404);
        }
    }

    /**
     * Validation de l'envoi en post
     */
    public function envoyerDocument(Request $request){
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
            // $nomFichier = $request->file('contenu')->getClientOriginalName();
            $nomFichier = Parametre::genererNomDuFichier($request->titre);//1
            // dd($nomFichier);
            // Générer l'empreinte numérique avec la fonction MD5
            $empreinte = Parametre::genererEmpreinte($contenu);//2
            // Récupérer une empreinte existante
            $existe = Parametre::verifierSiEmpreinteExiste($empreinte);//2
            if($existe === false){
                $document = new Document();
                $document->titre = $request->titre;
                $document->nomfichier = $nomFichier;
                $document->contenu = $base64Data;
                $document->empreinte_fichier = $empreinte;
                $document->date_cloture = $request->date_cloture;
                $document->etat_qualificatif_id = 3;
                $document->user_id = auth()->id();

                // Récupérer le destinataire
                $destinataire = User::find($request->destinataire_id);
                
                $document->user_id_2 = $destinataire->id;
                $document->pertinance = $request->pertinance;

                $document->save();
                Parametre::sauvegarderTampon($empreinte);//4
                $request->replace([
                    'matricule' => '',
                    'titre' => '',
                    'nomfichier' => '',
                    'contenu' => '',
                    'date_cloture' => '',
                    'nomComplet' => '',
                ]);
            
                // session()->flash('message', "");
                return redirect()->route('vue.liste.document')->with('Courrier envoyé avec succès !');
            }
            return redirect()->back()->with('warning', 'Le courrier existe déjà dans la base de données.');
        } else {
            // Gérer le cas où aucun fichier n'a été téléchargé
            return redirect()->back()->withInput()->withErrors(['contenu' => 'Veuillez sélectionner un fichier.']);
        }

        
    }

    /**
     * Bloc pour l'affichage du fichier dans une autre fenêtre
     */
    public function afficherFichier($id){
        $document = Document::find($id);
        // dd($document);
        if (!$document) {
            return abort(404, 'Document non trouvé');
        }

        // Décoder le contenu du fichier
        $contenu = base64_decode($document->fichier_scanner);

        // Déterminer le type MIME du fichier
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($contenu);

        // Retourner le contenu comme réponse
        return response($contenu)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $document->nom_fichier . '"');
    }

    /**
     * Modification du document
     */
    public function modifierDocument(Request $request){
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

        $documentTrouver = Document::find($request->documentId);
        // dd($documentTrouver);
        $documentTrouver->titre = $request->titre;
        $documentTrouver->nomfichier = $nomFichier;
        $documentTrouver->contenu = $base64Data;
        $document->empreinte_fichier = $empreinte;
        $documentTrouver->date_cloture = $request->date_cloture;
        $documentTrouver->etat_qualificatif_id = 3;
        $documentTrouver->user_id = auth()->id();

        // Récupérer le destinataire
        $destinataireTrouver = User::find($request->destinataire_id);
        $documentTrouver->user_id_2 = $destinataireTrouver->id;
        $documentTrouver->pertinance = $request->pertinance;
        // dd($document);
        $documentTrouver->save();
        
        $request->replace([
            'nomfichier' => '',
            'contenu' => '',
            'date_cloture' => '',
            'pertinance' => '',
        ]);
    
        // session()->flash('message', "");
        return redirect()->route('vue.liste.document')->with('Document envoyé avec succès !');
    }
    

}
