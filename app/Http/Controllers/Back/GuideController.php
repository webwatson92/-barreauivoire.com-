<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GuideRequest;
use App\Models\Guide;
use App\Models\Parametre;
use App\Models\Tampon;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class GuideController extends Controller
{
    public function index()
    {
        return view('back.guide.index');
    }

    public function chargerListeDeDocumentLu()
    {
        
        // Récupérer la liste des documents envoyés et reçus par cet utilisateur
        $documents = Guide::all();
       
        return Datatables::of($documents)
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
                if(Auth::user()->role == "admin" || Auth::user()->role == "superadmin" || Auth::user()->role == "barreau"){
                    $action = '
                        <a class="btn btn-primary btn-sm" href="/model-actes/'.$document->id.'" target="_blank">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).
                                '" download="'.$document->nom_fichier.'"><i class="fa-solid fa-download"></i>
                        </a>
                        
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
                                        <form action="'.route('guide.delete', $document->id).'"
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
                }else{
                    $action = '
                        <a class="btn btn-primary btn-sm" href="/guides/'.$document->id.'" target="_blank">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="btn btn-warning btn-sm" href="data:application/pdf;base64,'.base64_encode($contenu).
                                '" download="'.$document->nom_fichier.'"><i class="fa-solid fa-download"></i>
                        </a>
                    ';
                }
                return $action;
            })
            ->make(true);
    }

    //Fonction Post pour ajouter un guide dans la base de données
    public function create(GuideRequest $request)
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
            $existe = Parametre::verifierSiEmpreinteExiste($empreinte);//3
            if ($existe === false) {
                // L'empreinte du fichier n'existe pas dans la base de données
                $guide = new Guide();
                $guide->nom_fichier = strtolower($nomFichier);
                $guide->fichier_scanner = $base64Data; // Sauvegarde du fichier converti ici
                $guide->empreinte_fichier = $empreinte;
                $guide->save();
                //Enregistrer les empreinte de fichier
                Parametre::sauvegarderTampon($empreinte);//4
                // Après avoir enregistré, faire la redirection
                return redirect()->route('guide.index')->with('status', 'Le guide a bien été enregistré.');
            } 
            return redirect()->back()->with('warning', 'Le guide existe déjà dans la base de données.');
        } else {
            return redirect()->back()->withInput()->withErrors(['fichier_scanner' => 'Veuillez sélectionner un fichier.']);
        }
        
    }

    //Delete Guide
    public function delete($id)
    {
        try {
            $guide = Guide::findOrFail($id);
            $tampon = Tampon::where('empreinte_fichier', $guide->empreinte_fichier)->first();
            if ($tampon) {
                $tampon->delete();
            }
            $guide->delete();
            return back()->with('status', 'Guide et tampon supprimés avec succès');
        } catch (\Exception $e) {
            return back()->with('warning', 'Erreur lors de la suppression du guide : ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $guide = Guide::findOrFail($id);
        return view('back.guide.show', compact('guide'));
    }

}
