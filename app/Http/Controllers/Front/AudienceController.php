<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{AudienceRequest, RechercheAudienceRequest};
use App\Models\{Audience, User, Tribunal, Ville};
use Auth;
use Session;
use DataTables;
use Carbon\Carbon;

class AudienceController extends Controller
{
    /**
     * Affichage de la liste des client de chaque membre de l'application
     */
    public function vueListeDeAudience(){
        $tribunaux = Tribunal::all();
        $villes = Ville::all();
        return view('front.audience.listedeaudience', compact('tribunaux', 'villes'));
    }

    /**
     * Fonction pour l'ajout d'un audience
     */
    public function ajouterAudience(AudienceRequest $request) {
        //  dd("exists");
         if ($request->ajax()) {
            // Vérifier si un enregistrement similaire existe déjà
            $exists = Audience::where('audience', $request->audience)
                    ->where('tribunal_id', $request->tribunal_id)
                    ->where('ville_id', $request->ville_id)
                    ->where('date_conseil', $request->date_conseil)
                    ->where('heure_debut', $request->heure_debut)
                    ->where('heure_fin', $request->heure_fin)
                    ->exists();
           
            if ($exists) {
                return redirect()->route('vue.liste.audience')->with('message', 'Audience ajoutée avec succès');
            }
    
            $audience = new Audience();
            $audience->audience = $request->audience;
            $audience->tribunal_id = $request->tribunal_id;
            $audience->ville_id = $request->ville_id;
            $audience->date_conseil = $request->date_conseil;
            $audience->heure_debut = $request->heure_debut;
            $audience->heure_fin = $request->heure_fin;
            $audience->user_id = Auth::user()->id;
            $audience->save();
    
            return redirect()->route('vue.liste.audience')->with('message', 'Audience ajoutée avec succès');
        }
        return redirect()->route('vue.liste.audience')->with('message', 'Audience ajoutée avec succès');
    }    

    /**
     * Fonction pour la modification d'un audience
     */
    public function modifierAudience(AudienceRequest $request, $id){
        $audienceTrouver = Audience::find($id);
        if($audienceTrouver){
            $audienceTrouver->audience = $request->audience;
            $audienceTrouver->tribunal_id = $request->tribunal_id;
            $audienceTrouver->ville_id = $request->ville_id;
            $audienceTrouver->date_conseil = $request->date_conseil;
            $audienceTrouver->heure_debut = $request->heure_debut;
            $audienceTrouver->heure_fin = $request->heure_fin;
            $audienceTrouver->user_id = Auth::user()->id;
            $audienceTrouver->save();
            Session()->flash('message', "Audience modifié avec succès");
            return redirect('/liste/audience')->with('message', 'Audience ajoutée avec succès');
        }
        // return redirect('/liste/audience')->with('message', 'Audience ajoutée avec succès');
        // try {
        //     $audienceTrouver = Audience::find($id);
        //     if($audienceTrouver){
        //         $audienceTrouver->audience = $request->audience;
        //         $audienceTrouver->tribunal_id = $request->tribunal_id;
        //         $audienceTrouver->date_conseil = $request->date_conseil;
        //         $audienceTrouver->heure_debut = $request->heure_debut;
        //         $audienceTrouver->heure_fin = $request->heure_fin;
        //         $audienceTrouver->user_id = Auth::user()->id;
        //         $audienceTrouver->save();
        //         Session()->flash('message', "Audience modifié avec succès");
        //         return redirect('/liste/audience');
        //     }
        //     Session()->flash('message', "L'audience que vous essayé de modifier n'existe pas");
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    }

    /**
     * Affichage de la page de modification du Audience
     */
    public function supprimerAudience($id){
        Audience::where('id',$id)->delete();
        Session()->flash('message', 'Audience supprimé !');
        return redirect('/liste/audience');
        
    }

    /**
     * Fonction pour l'affichage de la vue de recherche
     */
    public function vueRechercheAudience(){
        $tribunaux = Tribunal::all();
        $villes = Ville::all();
        $audiences = Audience::all();
        return view("front.audience.vue-recherche-audience", compact('tribunaux', 'villes', 'audiences'));
    }

    /**
     * Fonction pour la recherche en post
     */
    public function rechercherAudience(RechercheAudienceRequest $request){
       
        $villeId = $request->ville_id;
        $tribunalId = $request->tribunal_id;
        $plageHoraire = $request->plage_horaire;
        $tableau = explode('-', $plageHoraire);
        $heureDebut = $tableau[0];
        $heureFin = $tableau[1];
        $dateConseil = $request->date_conseil;
        // dd($dateConseil ."- tribunal : ".$tribunalId.'- ville : '.$villeId.'- plage:'.$heureDebut.'- et:'.$heureFin);
        
        $audienceTrouver = Audience::with('tribunal', 'ville', 'user')->where('ville_id', $villeId)
                        ->where('tribunal_id', $tribunalId)
                        ->where('date_conseil', $dateConseil)
                        ->where('heure_debut', $heureDebut)
                        ->where('heure_fin', $heureFin)
                        ->first();
                        // dd($audienceTrouver);
        if(!empty($audienceTrouver) && !is_null($audienceTrouver)){
            return view('front.audience.resultat', compact('audienceTrouver'));
        }else{
            Session::flash('error', 'Aucun résultat trouvé !');
            return back();
        }
    }

    /**
     * Fonction pour l'affichage des retours de la recherche
     */
    public function vueResultatRecherche(){
        return view('front.audience.resultat');
    }


    /**
     * Fonction pour charger le tableau de la liste audience
     */
    public function chargerListeDeAudienceOLD(){
        $toutesLesAudiences = Audience::with('tribunal', 'ville')->get();
        // dd($toutesLesAudiences);
        $index = 0;
        return Datatables::of($toutesLesAudiences)
                ->addColumn('numero', function () use (&$index) {
                    $index++;
                    return $index;
                })
                ->addColumn('audience', function ($audience) {
                    //  $toutesLesAudiences->audience ? $toutesLesAudiences->audience : '';
                    return $audience->audience ? $audience->audience : '';
                })
                ->addColumn('tribunal', function ($audience) {
                    // return $toutesLesAudiences->tribunal->nom_tribunal ?? '';
                    return $audience->tribunal->nom_tribunal ?? '';
                })
                ->addColumn('ville', function ($audience) {
                    return $audience->ville->nom_ville ?? '';
                })
                ->addColumn('date_conseil', function ($audience) {
                    return $audience->date_conseil ? with(new Carbon($audience->date_conseil))->format('d/m/Y') : '';
                })
                ->addColumn('heure_debut', function ($audience) {
                    return $audience->heure_debut ?? '';
                })
                ->addColumn('heure_fin', function ($audience) {
                    return $audience->heure_fin ?? '';
                })
                ->editColumn('action', function($audience){
                    $action = '
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modal-ajout" data-id="'.$audience->id.'"
                            data-audience="'.$audience->audience.'"
                            data-tribunal_id="'.$audience->tribunal_id.'"
                            data-ville_id="'.$audience->ville_id.'"
                            data-date_conseil="'.$audience->date_conseil.'"
                            data-heure_debut="'.$audience->heure_debut.'"
                            data-heure_fin="'.$audience->heure_fin.'">
                            <i class="fa-solid fa-pencil fa-fw"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal'.$audience->id.'">
                                <i class="fa-solid fa-trash fa-fw"></i>
                        </button>
                        <div class="modal fade" id="deleteModal'.$audience->id.'" tabindex="-1"
                            role="dialog" aria-labelledby="deleteModalLabel'.$audience->id.'" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel'.$audience->id.'">Confirmation de
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
                                        <form action="'.route('supprimer.audience', $audience->id).'"
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
                ->rawColumns(['numero', 'audience', 'tribunal', 'ville', 'date_conseil', 'heure_debut', 'heure_fin', 'action'])
                ->make(true);
    }

    public function chargerListeDeAudience()
    {
        $toutesLesAudiences = Audience::latest()->get();
        // dd($toutesLesAudiences);
        return Datatables::of($toutesLesAudiences)
            ->addColumn('numero', function () use (&$index) {
                $index++;
                return $index;
            })
            ->addColumn('audience', function ($audience) {
                //  $toutesLesAudiences->audience ? $toutesLesAudiences->audience : '';
                return $audience->audience ? $audience->audience : '';
            })
            ->addColumn('tribunal', function ($audience) {
                //  $toutesLesAudiences->audience ? $toutesLesAudiences->audience : '';
                return $audience->tribunal->nom_tribunal ? $audience->tribunal->nom_tribunal : '';
            })
            ->addColumn('ville', function ($audience) {
                //  $toutesLesAudiences->audience ? $toutesLesAudiences->audience : '';
                return $audience->ville->nom_ville ? $audience->ville->nom_ville : '';
            })
            ->addColumn('date_conseil', function ($audience) {
                return $audience->date_conseil ? with(new Carbon($audience->date_conseil))->format('d/m/Y') : '';
            })
            ->addColumn('heure_debut', function ($audience) {
                return with(new Carbon($audience->heure_debut))->format('H:i') ?? ''.'H';
            })
            ->addColumn('heure_fin', function ($audience) {
                return $audience->heure_fin ?? '';
            })
            ->editColumn('action', function($audience){
                $action = '
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#modal-ajout" data-id="'.$audience->id.'"
                        data-audience="'.$audience->audience.'"
                        data-tribunal_id="'.$audience->tribunal_id.'"
                        data-date_conseil="'.$audience->date_conseil.'"
                        data-heure_debut="'.$audience->heure_debut.'"
                        data-heure_fin="'.$audience->heure_fin.'">
                        <i class="fa-solid fa-pencil fa-fw"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#deleteModal'.$audience->id.'">
                            <i class="fa-solid fa-trash fa-fw"></i>
                    </button>
                    <div class="modal fade" id="deleteModal'.$audience->id.'" tabindex="-1"
                        role="dialog" aria-labelledby="deleteModalLabel'.$audience->id.'" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel'.$audience->id.'">Confirmation de
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
                                    <form action="'.route('supprimer.audience', $audience->id).'"
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
            ->rawColumns(['numero', 'audience', 'tribunal', 'ville', 'date_conseil', 'heure_debut', 'heure_fin', 'action'])
            ->make(true);
    
    }


}
