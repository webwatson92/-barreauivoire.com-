@extends('layouts.base2')

@section('content')
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        <div class="col-sm-6" style="padding-bottom:1em">
                            <a class="btn btn-danger" href="{{ route('admin') }}"><i class="fa fa-reply" aria-hidden="true"></i> 
                            TABLEAU DE BORD</a>
                        </div>
                        <!-- <div class="col-sm-6" style="padding-bottom:1em">
                            <span type="button" style=""  wire:click="ajouterCode()" class="btn btn-primary"> 
                                <i class="fa fa-add" aria-hidden="true"></i> GENERATION DU CODE D'INSCRIPTION
                            </span>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('vue.listedeprofil') }}">
                                <i class="fa-solid fa-compass"></i>
                                Profils
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('vue.listedecode') }}">
                                <i class="fa-solid fa-landmark"></i>
                                Code d'inscription
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

