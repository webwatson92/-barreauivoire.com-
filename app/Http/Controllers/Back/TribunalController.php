<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TribunalRequest;
use App\Models\{Tribunal, User, Ville};
use DataTables;

class TribunalController extends Controller
{
   
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeTribunal(){
        $villes = Ville::all();
        return view('back.tribunal.listedetribunal', compact('villes'));
    }

    /**
     * Fonction pour l'ajout d'un tribunal
     */
    public function ajouterTribunal(TribunalRequest $request){
        $tribunal = new Tribunal();
        $tribunal->nom_tribunal = $request->nom_tribunal;
        // $tribunal->ville_id = $request->ville_id;
        $tribunal->save();
        User::historiserUneAction("ajouter tribunal");
        Session()->flash('message', "Tribunal ajouté avec succès");
        return redirect('/liste/de/tribunal');
    }

    /**
     * Affichage de la page de modification du tribunal
     */
    public function vueModificationDeTribunal($id){
        $tribunalTrouver = Tribunal::find($id);
        return view('back.tribunal.vue-modification-tribunal', compact('tribunalTrouver'));
    }

    /**
     * Fonction pour la modification d'un tribunal
     */
    public function modifierTribunal(TribunalRequest $request, $id){
        try {
            $tribunalTrouver = Tribunal::find($id);
            if($tribunalTrouver){
                $tribunalTrouver->nom_tribunal = $request->nom_tribunal;
                // $tribunalTrouver->ville_id = $request->ville_id;
                $tribunalTrouver->save();
                Session()->flash('message', "Tribunal modifié avec succès");
                return redirect('/liste/de/tribunal');
            }
            Session()->flash('message', "Le tribunal que vous essayé de modifier n'existe pas");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Affichage de la page de modification du tribunal
     */
    public function supprimerTribunal($id){
        Tribunal::where('id',$id)->delete();
        Session()->flash('message', 'Tribunal supprimé !');
        User::historiserUneAction("suppression tribunal");

        return redirect('/liste/de/tribunal');
        
    }

    /**
     * Fonction pour charger le tableau de la liste des tribunaux
     */
    public function chargerListeDeTribunaux(){
        $tribunal = Tribunal::with('ville')->get();
        // dd($tribunal);
        $index = 0;
        return Datatables::of($tribunal)
                ->addColumn('numero', function () use (&$index) {
                    $index++;
                    return $index;
                })
                ->addColumn('nom_tribunal', function ($tribunal) {
                    return $tribunal->nom_tribunal ? $tribunal->nom_tribunal : '';
                })
                // ->addColumn('ville', function ($tribunal){ 
                //     $ville = $tribunal->ville->nom_ville;
                //     return $ville ? $ville : '';
                // })
                ->editColumn('action', function ($tribunal){
                    $action = '
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-ajout" data-id="'.$tribunal->id.'"
                                data-nom_tribunal="'.$tribunal->nom_tribunal.'"
                                <i class="fa-solid fa-pencil fa-fw"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal'.$tribunal->id.'">
                                <i class="fa-solid fa-trash fa-fw"></i>
                        </button>
                        <div class="modal fade" id="deleteModal'.$tribunal->id.'" tabindex="-1"
                            role="dialog" aria-labelledby="deleteModalLabel'.$tribunal->id.'" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel'.$tribunal->id.'">Confirmation de
                                            suppression</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce tribunal ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Annuler</button>
                                        <form action="'.route('supprimer.tribunal', $tribunal->id).'"
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
                    return $action;
                })
                ->rawColumns(['numero', 'nom_tribunal', 'ville', 'action'])
                ->make(true);
    }

}
