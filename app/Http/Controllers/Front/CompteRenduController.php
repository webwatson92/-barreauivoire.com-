<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompteRenduRequest;
use App\Models\CompteRendu;
use App\Models\Tampon;
use App\Models\Parametre;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class CompteRenduController extends Controller
{
    public function vueCompteRendu()
    {
        $compteRendus = CompteRendu::all();
        return view('front.compte-rendu.liste', compact('compteRendus'));
    }

    public function afficherFichierOLD($id){
        $document = CompteRendu::find($id);
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

    public function afficherFichier($id){
        $compteRendu = CompteRendu::find($id);
        if ($compteRendu) {
            return view('front.compte-rendu.show', compact('compteRendu', 'id'));
        } else {
            return redirect()->route('compteRendu.index')->withErrors(['compteRendu' => 'Compte rendu non trouvé.']);
        }
    }

    public function chargerListeDeCompteRendu()
    {
        // Récupérer la liste des documents envoyés et reçus par cet utilisateur
        $documents = CompteRendu::all();
        
        return DataTables::of($documents)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('nomFichier', function ($document) {
                return $document->nom_fichier;
            })
            ->addColumn('dateAjout', function ($document) {
                return $document->created_at->locale('fr')->diffForHumans();
            })
            ->editColumn('action', function($document){
                $contenu = base64_decode($document->fichier_scanner);
                // dd($contenu);
                if(Auth::user()->role != "admin" || Auth::user()->role != "superadmin" || Auth::user()->role != "barreau"){
                    $action = '
                        <a class="btn btn-primary btn-sm" href="/compte-rendus/afficher/'.$document->id.'" target="_blank">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).
                                '" download="'.$document->nom_fichier.'"><i class="fa-solid fa-download"></i>
                        </a>
                    ';
                }else{
                    $action = '
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal'.$document->id.'"><i class="fa-solid fa-trash fa-fw"></i>
                        </button>
                        <div class="modal fade" id="deleteModal'.$document->id.'" tabindex="-1"
                            role="dialog" aria-labelledby="deleteModalLabel'.$document->id.'" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel'.$document->id.'">Confirmation de
                                            suppression</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce audience ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Annuler</button>
                                        <form action="'.route('supprimer.compterendu', $document->id).'"
                                            method="POST">
                                            '.csrf_field().'
                                            '.method_field('DELETE').'
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
                return $action;
            })
            ->make(true);
    }

    //Fonction Post pour ajouter un compte rendu dans la base de données
    public function create(CompteRenduRequest $request)
    {
        $request->validated();
        
        if ($request->hasFile('fichier_scanner')) {
            // Obtenir le contenu du fichier PDF
            $contenu = file_get_contents($request->file('fichier_scanner')->path());
            $base64Data = base64_encode($contenu); // Conversion du fichier
            $nomFichier = Parametre::genererNomDuFichier($request->nom_fichier);//1
            // Générer l'empreinte numérique avec la fonction MD5
            $empreinte = Parametre::genererEmpreinte($contenu);//2
            // Récupérer une empreinte existante
            $existe = Parametre::verifierSiEmpreinteExiste($empreinte);//2
            if($existe===false){
                // L'empreinte du fichier n'existe pas dans la base de données
                $compteRendu = new CompteRendu();
                $compteRendu->nom_fichier = strtolower($nomFichier);
                $compteRendu->fichier_scanner = $base64Data; // Sauvegarde du fichier converti ici
                $compteRendu->empreinte_fichier = $empreinte;
                $compteRendu->save();
                //Enregistrer les empreinte de fichier
                Parametre::sauvegarderTampon($empreinte);//4
                // Après avoir enregistré, faire la redirection
                return redirect()->route('vue.compte-rendu')->with('status', 'Le compte rendu a bien été enregistré.');
            }
            return redirect()->back()->with('warning', 'Le compte rendu existe déjà dans la base de données.');
        } else {
            return redirect()->back()->withInput()->withErrors(['fichier_scanner' => 'Veuillez sélectionner un fichier.']);
        }

    }

    //Delete Compte Rendu
    public function delete($id)
    {
        $compteRendu = CompteRendu::find($id);

        // Récupérer une empreinte existante
        $tampon = Tampon::where('empreinte_fichier', $compteRendu->empreinte_fichier)->first();
        if($tampon){
            $tampon->delete();
        }

        if (!$compteRendu) {
            return redirect()->route('vue.compte-rendu')->with('error', 'Compte rendu non trouvé.');
        }

        $compteRendu->delete();

        // Après avoir supprimé, faire la redirection avec un message de succès
        return redirect()->route('vue.compte-rendu')->with('status', 'Le compte rendu a bien été supprimé.');
    }


    public function show($id)
    {
        $compteRendu = CompteRendu::find($id);
        if ($compteRendu) {
            return view('front.compte-rendu.liste', compact('compteRendu', 'id'));
        } else {
            return redirect()->route('vue.compte-rendu')->withErrors(['documentId' => 'Compte rendu non trouvé.']);
        }
    }

}
