@extends('layouts.base2')
@section('title', "Interface d'envoi de d'attestation")
@push('styles')

@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Modification des informations</h1> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        <div class="row">
            @include('layouts.flash-message')
        </div>
        <form method="post" action="{{ route('envoyer.attestation') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="card col-sm-6">
                <div class="card-header card-primary"></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nom">Nom du fichier</label>
                            <input type="hidden" value="{{ $demande->id }}" name="demandeid">
                            <input type="hidden" value="{{ $demande->user_id }}" name="destinataireId">
                            <input required="required" type="text" class="form-control" name="nomFichier" placeholder="Nom du fichier"> 
                            <span class="text-danger">@error('nomFichier'){{$message}} @enderror</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="contenu">Fichier au format (PDF) *</label> <br>
                            <input required="required" type="file" class="form-control" name="contenu"> 
                            <span class="text-danger">@error('contenu'){{$message}} @enderror</span>
                        </div>
                        <br>
                        <div class="form-group" style="padding-bottom: 2em; padding-top: 1em">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="/liste/attestation" wire:navigate class="btn btn-danger"><i class="fa fa-reply"></i> RETOUR</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn form-control btn-success"><i class="fa fa-save"></i> Envoyer maintenant</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('footer')
    <script>

    </script>

@stop