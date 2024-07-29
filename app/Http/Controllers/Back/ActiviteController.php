<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ActiviteRequest;
use App\Models\Activite;
use DataTables;
use Auth;


class ActiviteController extends Controller
{
    public function index()
    {
        return view('back.evenements.activite');
    }

    public function chargerListeActivite()
    {
        // Récupérer la liste des activité enregistrer par le barreau ou l'admin
        $activites = Activite::all();
        return DataTables::of($activites)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('nom', function ($activite) {
                return $activite->nom;
            })
            ->addColumn('lieu', function ($activite) {
                return $activite->lieu;
            })
            ->addColumn('dateAjout', function ($activite) {
                return $activite->created_at->locale('fr')->diffForHumans();
            })
            ->editColumn('action', function ($activite) {
                if(Auth::user()->role == "admin" || Auth::user()->role == "superadmin" || Auth::user()->role == "barreau"){
                    $action = '
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editModal' . $activite->id . '"><i class="fa-solid fa-pencil fa-fw"></i></button>
                        <div class="modal fade" id="editModal' . $activite->id . '" tabindex="-1" role="dialog"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="activite">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Modifier l\'activité</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="/activites/' . $activite->id . '">
                                                        ' . csrf_field() . '
                                                        ' . method_field('PUT') . '
                                                        <div class="modal-body">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="nom">Nom</label>
                                                                    <input type="text" class="form-control" name="nom" id="nom"
                                                                    value="' . $activite->nom . '">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="lieu">Lieu</label>
                                                                    <input type="text" class="form-control" name="lieu" id="lieu"
                                                                    value="' . $activite->lieu . '">
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Fermer</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal' . $activite->id . '"><i class="fa-solid fa-trash fa-fw"></i>
                        </button>
                        <div class="modal fade" id="deleteModal' . $activite->id . '" tabindex="-1"
                            role="dialog" aria-labelledby="deleteModalLabel' . $activite->id . '" aria-hidden="true">
                            <div class="modal-dialog" role="activite">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel' . $activite->id . '">Confirmation de
                                            suppression</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer cet élément ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Annuler</button>
                                        <form action="' . route('activite.delete', $activite->id) . '"
                                            method="POST">
                                            ' . csrf_field() . '
                                            ' . method_field('DELETE') . '
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }else{
                    $action = '
                        <a class="btn btn-success btn-sm">En cours</a>
                    ';
                }
               
                return $action;
            })
            ->make(true);
    }

    //Fonction Post pour ajouter une activité dans la base de données
    public function create(ActiviteRequest $request)
    {
        $request->validated();

        $activite = new Activite();
        $activite->nom = $request->nom;
        $activite->lieu = $request->lieu;
        $activite->save();
        // Après avoir enregistré, faire la redirection
        return redirect()->route('activite.index')->with('status', 'L\'activité a bien été enregistré.');
    }

    //Delete activité
    public function delete($id)
    {
        $activite = Activite::find($id);

        if (!$activite) {
            return redirect()->route('activite.index')->with('error', 'Activité non trouvé.');
        }

        $activite->delete();

        // Après avoir supprimé, faire la redirection avec un message de succès
        return redirect()->route('activite.index')->with('status', 'L\'activité a bien été supprimé.');
    }


    //Affiche une activité
    public function show($id)
    {
        $activite = Activite::find($id); //Récupéré l'activité

        return view('auth.activite.show', compact('activite'));
    }

    //Modifier une activité
    public function update(ActiviteRequest $request, $id)
    {
        $request->validated();

        $activite = Activite::findOrFail($id);
        $activite->nom = $request->nom;
        $activite->lieu = $request->lieu;
        $activite->save();

        return redirect()->route('activite.index')->with('status', 'Activité mise à jour avec succès');
    }
}
