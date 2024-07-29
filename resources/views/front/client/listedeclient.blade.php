@extends('layouts.base2')
@section('title', 'Interface de gestion des clients')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des clients</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Liste de client</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" 
                                        role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Client Favoris</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.client.client-list')                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        @livewire('back.client.client-list-favoris')                                     
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
    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "ci", // Pays par défaut
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });

        iti.promise.then(function() {
            var countryCodeInput = document.querySelector("#country-code");
            input.addEventListener("countrychange", function() {
                countryCodeInput.value = iti.getSelectedCountryData().dialCode;
            });
        });
        $(document).ready(function(){
            
            if ($.fn.DataTable.isDataTable('#liste_client')) {
                $('#liste_client').DataTable().destroy();
            }
            
            if ($.fn.DataTable.isDataTable('#liste_client_favoris')) {
                $('#liste_client_favoris').DataTable().destroy();
            }

            var oTable = $('#liste_client').DataTable({
                processing: true,
                serverSide: true,
                language : { "url": "{!! url("langue/datatable/French.json") !!}"},
                ajax: {
                    url : "{!! route('charger.liste.client') !!}",
                    data : function(d) {}
                },
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'code', name: 'code', searchable: true },
                    { data: 'nom', name: 'nom', searchable: true },
                    { data: 'adresse', name: 'adresse', searchable: true },
                    { data: 'tel', name: 'tel', searchable: true },
                    { data: 'source', name: 'source', searchable: true },
                    { data: 'montant', name: 'montant', searchable: true },
                    { data: 'action', name: 'action', searchable: false }
                ]
            });

            var oTable =  $('#liste_client_favoris').DataTable({
                processing: true,
                serverSide: true,
                language : { "url": " {!! url("langue/datatable/French.json") !!} "},
                ajax: {
                    url : "{!! route('charger.liste.client.favoris') !!}",
                    data : function(d) {}
                },
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'code', name: 'code', searchable: true },
                    { data: 'nom', name: 'nom', searchable: true },
                    { data: 'adresse', name: 'adresse', searchable: true },
                    { data: 'tel', name: 'tel', searchable: true },
                    { data: 'source', name: 'source', searchable: true },
                    { data: 'montant', name: 'montant', searchable: true },
                    { data: 'action', name: 'action', searchable: false }
                ]
            });

        });

        /**
         * Pour le chargement des actions de mise à jour et suppression
         */
        
    </script>

@stop