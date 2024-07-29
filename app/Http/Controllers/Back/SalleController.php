<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SalleRequest;
use App\Models\Salle;
use Auth;
use DataTables;
use Carbon\Carbon;

class SalleController extends Controller
{
    public function vueListeDeSalle(){
        return view('back.salle.listesalle');
    }

    public function chargerLaListeDesSalle(){
            $salle = Salle::orderBy('created_at', 'desc');
            // dd($salle);
            return Datatables::of($salle)
                ->addColumn('numero', function () use (&$index) {
                    $index++;
                    return $index;
                })
                ->addColumn('image', function ($salle) {
                    $image = '<img src="' . asset('storage/salles/' . $salle->image) . '" width="60">';
                    return $image;
                })                
                ->addColumn('nom', function ($salle) {
                    return $salle->nom;
                })
                ->addColumn('description', function ($salle) {
                    return $salle->description ?? "Pas renseigné";
                })
                ->addColumn('capacite', function ($salle) {
                    return $salle->capacite;
                })
                ->addColumn('lieu', function ($salle) {
                    return $salle->lieu;
                })
                ->addColumn('cout', function ($salle) {
                    return number_format($salle->cout) ." FCFA";
                })
                ->addColumn('etat', function ($salle) {
                    $etat = "";
                    if($salle->etat == 7){
                        $etat = "Occuper";
                    }else{
                        $etat = "libre";
                    }
                    return $etat;
                })
                ->editColumn('action', function ($salle) {
                    $action = '
                        <a href="/edition/salle/'.$salle->id.'" wire:navigate class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil fa-fw"></i></a>
                        <button wire:click="deletePost('.$salle->id.')" wire:confirm="Etes-vous sûre de vouloir supprimer?" 
                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash fa-fw"></i></button>';
                    return $action;
                })
            ->rawColumns(['nom', 'tel', 'action'])
            ->make(true);
    }

    /**
     * Fonction d'affichage de la salle 
     */

     public function vueEnregistrerSalle(){
        return view('back.salle.vuSaveSalle');
     }

    /**
     * Fonction pour sauvegarder une salle de formation
     */
    public function enregistrerSalle(SalleRequest $request){
        
        $salle = new Salle();
        
        if($request->image){
            $imageName = Carbon::now()->timestamp.'.'.$request->image->extension();
            $request->image->storeAs('salles', $imageName);
            $salle->image = $imageName;
        }

        $salle->nom = $request->nom;
        $salle->description = $request->description;
        $salle->capacite = $request->capacite;
        $salle->lieu = $request->lieu;
        $salle->cout = $request->cout;
        $salle->etat_qualificatif_id = $request->etat_qualificatif_id;
        $salle->user_id = Auth::user()->id;

        $salle->save();
        Session()->flash('message', "Salle ajouté avec succès !");
        return redirect('/liste/de/salle');
    }

    /**
     * Fonction pour l'affichage de la vue de modification de la salle du barrea
     */
    public function vueEditionSalle($salleId){
        $salleInfo = salle::find($salleId);
        return view('back.salle.editionsalle', compact('salleInfo'));
    }

    /**
     * Modification des infos de la salle
     */
    public function modifierSalle(SalleRequest $request){
        $salleTrouver = Salle::find($request->salleid);
        // dd($salleTrouver->nom);
        if($salleTrouver->image){
            $imageName = Carbon::now()->timestamp.'.'.$request->image->extension();
            $request->image->storeAs('salles', $imageName);
            $salleTrouver->image = $imageName;
        }

        $salleTrouver->nom = $request->nom;
        $salleTrouver->description = $request->description;
        $salleTrouver->capacite = $request->capacite;
        $salleTrouver->lieu = $request->lieu;
        $salleTrouver->cout = $request->cout;
        $salleTrouver->etat_qualificatif_id = $request->etat_qualificatif_id;
        $salleTrouver->user_id = auth()->id();
        $salleTrouver->save();
        session()->flash('message', "Modification éffectuéé avec succès !");
        return redirect('/liste/de/salle');
    }


}
