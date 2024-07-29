<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class MyTestController extends Controller
{
    public function dataTableLogic(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('*');
            return datatables()->of($users)
                ->make(true);
        }
          
        return view('y-dataTables');
    }

    public function test(){

        $listeDesUtilisateur = User::all();
        // dd($listeDesUtilisateur);
        return Datatables::of($listeDesUtilisateur)
        ->addColumn('id', function ($user) {
            return $user->id;
        })
        ->addColumn('nom_prenom', function ($user) {
            return $user->name . ' ' . $user->prenom;
        })
        ->addColumn('date_naissance', function ($user) {
            return (!empty($user->date_naissance) && !is_null($user->date_naissance))
                ? Carbon::createFromFormat('Y-m-d', $user->date_naissance)->format('d/m/Y')
                : '';
        })
        ->editColumn('action', function ($user) {
            return sprintf("<a href='%s' class='btn btn-success'><i class ='glyphicon glyphicon-align-justify'></i></a>");
        })
        ->rawColumns(['id', 'nom_prenom', 'date_naissance', 'action'])
        ->make(true);
    }
}
