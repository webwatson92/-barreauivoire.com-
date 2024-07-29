<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\VilleRequest;
use App\Models\{User, Ville};
use DataTables;

class VilleController extends Controller
{
    
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeVille(){
        $villes = Ville::all();
        // dd($villes);
        return view('back.ville.listedeville', compact('villes'));
    }

    /**
     * Fonction pour l'ajout d'un ville
     */
    public function ajouterVille(VilleRequest $request){
        $ville = new Ville();
        $ville->nom_ville = $request->nom_ville;
        $ville->save();
        Session()->flash('message', "Ville ajouté avec succès");
        return redirect('/liste/des/villes');
    }

    /**
     * Affichage de la page de modification du ville
     */
    public function vueModificationDeVille($id){
        $villeTrouver = Ville::find($id);
        return view('back.ville.vue-modification-ville', compact('villeTrouver'));
    }

    /**
     * Fonction pour la modification d'un ville
     */
    public function modifierVille(VilleRequest $request, $id){
        try {
            $villeTrouver = Ville::find($id);
            if($villeTrouver){
                $villeTrouver->nom_ville = $request->nom_ville;
                $villeTrouver->save();
                Session()->flash('message', "Ville modifié avec succès");
                return redirect('/liste/des/villes');
            }
            Session()->flash('message', "Le ville que vous essayé de modifier n'existe pas");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Affichage de la page de modification du ville
     */
    public function supprimerVille($id){
        Ville::where('id',$id)->delete();
        Session()->flash('message', 'Ville supprimé !');
        User::historiserUneAction("suppression");

        return redirect('/liste/des/villes');
        
    }

    /**
     * Fonction pour charger le tableau de la liste des Villes
     */
    public function chargerListeDeVille(){
        $ville = Ville::all();
        // dd($ville);
        $index = 0;
        return Datatables::of($ville)
                ->addColumn('numero', function () use (&$index) {
                    $index++;
                    return $index;
                })
                ->addColumn('nom_ville', function ($ville) {
                    return $ville->nom_ville ? $ville->nom_ville : '';
                })
                ->editColumn('action', function($ville){
                    $action = '
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-ajout" data-id="'.$ville->id.'"
                                data-nom_ville="'.$ville->nom_ville.'">
                                <i class="fa-solid fa-pencil fa-fw"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal'.$ville->id.'">
                                <i class="fa-solid fa-trash fa-fw"></i>
                        </button>
                        <div class="modal fade" id="deleteModal'.$ville->id.'" tabindex="-1"
                            role="dialog" aria-labelledby="deleteModalLabel'.$ville->id.'" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel'.$ville->id.'">Confirmation de
                                            suppression</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce ville ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Annuler</button>
                                        <form action="'.route('supprimer.ville', $ville->id).'"
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
                ->rawColumns(['numero', 'nom_ville', 'action'])
                ->make(true);
    }

}
