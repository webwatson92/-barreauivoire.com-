@extends('layouts.base2')

@section('title', "Recherche d'audience")

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush

@section('content')
    @section('titlePage')
        <h1 class="m-0">Liste des audiences</h1>
    @stop

    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                                            role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Recherche</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <br>
                                        <div class="row">
                                            <h2>Renseignez ici l'audience pour laquelle vous cherchez un confrère </h2>
                                        </div>
                                        <br>
                                        <form method="POST" action="{{ route('rechercher.audience') }}" id="form-ajout-audience">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="ville_id">Ville du tribunal <span style="color:red">*</span></label>
                                                        <select name="ville_id" id="ville_id" class="form-control">
                                                            <option value="">Selectionner une ville</option>
                                                            @foreach($villes as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nom_ville }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('ville_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="date_conseil">Date d'audience <span style="color:red">*</span></label>
                                                        <select name="date_conseil" id="date_conseil" class="form-control">
                                                            <option value="">Selectionner une date d'audience</option>
                                                            @foreach($audiences as $item)
                                                                <option value="{{ $item->date_conseil }}">{{ \Carbon\Carbon::parse($item->date_conseil)->format('d/m/Y') }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('date_conseil')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="tribunal_id">Tribunal<span style="color:red">*</span></label>
                                                        <select name="tribunal_id" id="tribunal_id" class="form-control">
                                                            <option value="">Selectionner un tribunal</option>
                                                            @foreach($tribunaux as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nom_tribunal }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('tribunal_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="plage_horaire">Plage horaire <span style="color:red">*</span></label>
                                                        <select name="plage_horaire" id="plage_horaire" class="form-control">
                                                            <option value="">Choisir une plage horaire</option>
                                                            @foreach($audiences as $item)
                                                                <option value="{{ \Carbon\Carbon::parse($item->heure_debut)->format('H:i') }}-{{ \Carbon\Carbon::parse($item->heure_fin)->format('H:i') }}">
                                                                    {{ \Carbon\Carbon::parse($item->heure_debut)->format('H:i') }}H - {{ \Carbon\Carbon::parse($item->heure_fin)->format('H:i') }}H
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('plage_horaire')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a type="button" href="{{route('vue.liste.audience') }}" class="btn btn-danger form-control"><i class="fa fa-reply"></i> Retour</a>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <button type="submit" class="btn btn-success form-control"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('footer')
@stop
