@extends('layouts.base2')
@section('title', 'Interface de gestion des conclusions')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des conclusions</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes des conclusions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-conclusion-envoye-tab" data-toggle="pill" href="#custom-conclusion-envoye" 
                                        role="tab" aria-controls="custom-conclusion-envoye" aria-selected="false">conclusion Envoyé</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-conclusion-recu-tab" data-toggle="pill" href="#custom-conclusion-recu" 
                                        role="tab" aria-controls="custom-conclusion-recu" aria-selected="false">conclusions Reçu & Confirmer</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="custom-conclusion-traite-tab" data-toggle="pill" href="#custom-conclusion-traite" 
                                        role="tab" aria-controls="custom-conclusion-traite" aria-selected="false">conclusions Traité</a>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.conclusion.conclusion-list')                                    
                                    </div>
                                    <div class="tab-pane fade" id="custom-conclusion-envoye" role="tabpanel" aria-labelledby="custom-conclusion-envoye-tab">
                                        @livewire('back.conclusion.conclusion-list-envoyer')
                                    </div>
                                    <div class="tab-pane fade" id="custom-conclusion-recu" role="tabpanel" aria-labelledby="custom-conclusion-recu-tab">
                                        @livewire('back.conclusion.conclusion-list-lu')  
                                    </div>
                                    <!-- <div class="tab-pane fade" id="custom-conclusion-traite" role="tabpanel" aria-labelledby="custom-conclusion-traite-tab">
                                        conclusions traités
                                    </div> -->
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
            if ($.fn.DataTable.isDataTable('#liste_conclusion')) {
                $('#liste_conclusion').DataTable().destroy();
            }
            var oTable = $('#liste_conclusion').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.conclusion', $user_id) !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'img_pdf', name: 'img_pdf'},
                    { data: 'titre', name: 'titre', searchable: true },
                    { data: 'nomfichier', name: 'nomfichier', searchable: true },
                    { data: 'date_cloture', name: 'date_cloture'},
                    { data: 'destinataire', name: 'destinataire', searchable: true },
                    { data: 'etat', name: 'etat', searchable: true },
                    { data: 'action', name: 'action', searchable: false }
                ]
            });

            if ($.fn.DataTable.isDataTable('#liste_conclusion_lu')) {
                $('#liste_conclusion_lu').DataTable().destroy();
            }
            var oTable = $('#liste_conclusion_lu').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.conclusion.lu', $user_id) !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'img_pdf', name: 'img_pdf'},
                    { data: 'titre', name: 'titre', searchable: true },
                    { data: 'nomfichier', name: 'nomfichier', searchable: true },
                    { data: 'date_cloture', name: 'date_cloture'},
                    { data: 'destinataire', name: 'destinataire', searchable: true },
                    { data: 'etat', name: 'etat', searchable: true },
                ]
            });

            if ($.fn.DataTable.isDataTable('#liste_conclusion_envoyer')) {
                $('#liste_conclusion_envoyer').DataTable().destroy();
            }
            var oTable = $('#liste_conclusion_envoyer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.conclusion.envoyer', $user_id) !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'img_pdf', name: 'img_pdf'},
                    { data: 'titre', name: 'titre', searchable: true },
                    { data: 'nomfichier', name: 'nomfichier', searchable: true },
                    { data: 'date_cloture', name: 'date_cloture'},
                    { data: 'destinataire', name: 'destinataire', searchable: true },
                    { data: 'etat', name: 'etat'},
                    { data: 'action', name: 'action'},
                ]
            });
            setInterval(function(){
                location.reload();
            }, 300000); //Tous les deux minutes

        });

       
        /**
         * Pour le chargement des actions de mise à jour et suppression
         */
        
    </script>

@stop