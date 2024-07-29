@extends('layouts.base2')
@section('title', 'Interface de gestion de salle')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des salles en vente</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Liste de salle</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.salle.salle-list')                                    
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

        $(document).ready(function(){
            // $("#dateMask").inputmask("dd/mm/yyyy", {"placeholder": "dd-mm-yyyy"});
            if ($.fn.DataTable.isDataTable('#liste_salle')) {
                $('#liste_salle').DataTable().destroy();
            }
            
            var oTable = $('#liste_salle').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.salle') !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'image', name: 'image'},
                    { data: 'nom', name: 'nom', searchable: true },
                    { data: 'description', name: 'description', searchable: true },
                    { data: 'capacite', name: 'capacite'},
                    { data: 'lieu', name: 'lieu', searchable: true },
                    { data: 'etat', name: 'etat', searchable: true },
                    { data: 'cout', name: 'cout', searchable: true },
                    { data: 'action', name: 'action', searchable: false }
                ]
            });

        });

       
        /**
         * Pour le chargement des actions de mise à jour et suppression
         */
        
    </script>

@stop