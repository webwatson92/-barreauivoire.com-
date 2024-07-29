@extends('layouts.base2')

@section('content')
    <div class="row">

        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #3ade9f; font-size:20px;">
                <div class="card-body text-center text-white">
                        <a href="{{ route('admin.droit.accueil') }}">Compte</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $compteUtilisateur ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #272d69; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('information.index') }}">{{ $informations > 1 ? "Informations" : "Information" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $informations ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3" >
            <div class="card" style="backg-round-color: #3ade9f; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('admin.liste.validation') }}">{{ $profilEnAttenteDeValidation > 1 ? "En Attentes" : "En Attente" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                {{ $profilEnAttenteDeValidation ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3" >
            <div class="card" style="backg-round-color: #3ade9f; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('vue.liste.document') }}">Total courrier</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                {{ $tousLesCourriers ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #3ade9f; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('evenement.index') }}">{{ $evenements > 1 ? "Evènements" : "Evènement" }} </a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $evenements ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #272d69; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('activite.index') }}">{{ $activites > 1 ? "Activités" : "Activité" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $Activites ?? 0 }}
                </div>
            </div>
        </div>
    </div>
@stop

