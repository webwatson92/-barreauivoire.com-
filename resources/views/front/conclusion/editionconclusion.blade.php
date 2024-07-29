@extends('layouts.base2')
@section('title', "Interface de modification de conclusion")
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Modification des informations</h1> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')
        
        <div class="row col-sm-6">
            <form method="post" action="{{ route('modifier.conclusion')}}" autocomplete="on" enctype="multipart/form-data">
                <input type="hidden" name="conclusionId" value="{{$conclusionInfo->id}}">
                @csrf
                <div class="card">
                    <div class="card-header card-primary"></div>
                        <div class="card-body">
                            <div class="row" style="padding-bottom:1em">
                                <div class="col-sm-12" style="padding-bottom:1em">
                                    <div class="form-group">
                                        <label for="titre"><b>Titre de la conclusion</b></label>
                                        <input required="required" value="{{ $conclusionInfo->titre }}" name="titre" type="text" class="form-control" name="titre" placeholder="Titre du conclusion"> 
                                        <span class="text-danger">@error('titre'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="padding-bottom:1em">
                                    <div class="form-group">
                                        <label for="titre"><b>Matricule</b></label>
                                        <input required="required" type="text" class="form-control" name="matricule" id="matricule" placeholder="Saisir son matricule">
                                    </div>
                                </div>
                                <div class="col-sm-12" style="padding-bottom:1em">
                                    <div class="form-group">
                                        <label for="nomComplet"><b>Nom complet du destinataire</b></label>
                                        <input type="text" id="nomCompletTrouver" disabled class="form-control">
                                        <input type="hidden" id="nomCompletTrouver" name="nomComplet">
                                        <input type="hidden" id="destinataireIdTrouver" name="destinataire_id">
                                    </div>
                                </div>
                                <div class="col-sm-12" style="padding-bottom:1em">
                                    <div class="form-group">
                                        <label for="contenu"><b>Importer le fichier (Format: PDF)</b></label>
                                        <input required="required" type="file" name="contenu" class="form-control">
                                        <span class="text-danger">@error('contenu'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="form-group col-sm-6">
                                        <label for="tel"><b>Traiter avant la date du</b> </label>
                                        <input type="date" value="{{ $conclusionInfo->date_cloture }}" name="date_cloture" required="required" name="date_cloture" id="date_cloture" class="form-control input-md">                                    <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="tel"><b>Niveau de pertinance</b> </label>
                                        <select {{ $conclusionInfo->pertinance }}" name="pertinance" class="form-control input-md" required="required" required="required">
                                            @foreach($statuts as $statut)
                                                <option value="{{ $statut->titre}}">{{ $statut->titre}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('pertinance'){{$message}} @enderror</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a class="btn btn-danger" href="/liste/de/conclusion" wire:navigate><i class="fa fa-reply"></i> RETOUR</a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn form-control btn-success">
                                            <i class="fa-solid fa-paper-plane"></i> Envoyer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop
@section('footer')
    <script>
        $('#matricule').on('change', function(){
            var matricule =  $('#matricule').val();
            $.ajax({
                url: '/chargerlenometprenomajax/' + matricule,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        // Gérer l'erreur si l'utilisateur n'est pas trouvé
                        console.error(response.error);
                    } else {
                        // Mettre à jour le champ "Nom complet"
                        var nomComplet = response.nom + ' ' + response.prenom;
                        var destinataireId = response.destinataire_id;
                        $('#nomCompletTrouver').val(nomComplet);
                        $('#destinataireIdTrouver').val(destinataireId);
                    }
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs de la requête AJAX
                    console.error(error);
                }
            });
        });
        $(document).ready(function(){
            // Obtenir la date actuelle
            var currentDate = new Date();
            var year = currentDate.getFullYear();

            // Définir la date maximale
            var endOfYear = new Date(year, 11, 31); // Décembre est le mois 11
            var formattedEndDate = endOfYear.toISOString().split('T')[0]; // Format ISO YYYY-MM-DD

            // Définir la date maximale dans l'élément input
            $('#date_cloture').attr('max', formattedEndDate);
        });
    </script>

@stop