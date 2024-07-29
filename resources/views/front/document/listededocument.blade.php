@extends('layouts.base2')
@section('title', 'Interface de gestion des documents')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des documents</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes des documents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-document-envoye-tab" data-toggle="pill" href="#custom-document-envoye" 
                                        role="tab" aria-controls="custom-document-envoye" aria-selected="false">Document Envoyé</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-document-recu-tab" data-toggle="pill" href="#custom-document-recu" 
                                        role="tab" aria-controls="custom-document-recu" aria-selected="false">Documents Reçu & Confirmer</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="custom-document-traite-tab" data-toggle="pill" href="#custom-document-traite" 
                                        role="tab" aria-controls="custom-document-traite" aria-selected="false">Documents Traité</a>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.document.document-list')                                    
                                    </div>
                                    <div class="tab-pane fade" id="custom-document-envoye" role="tabpanel" aria-labelledby="custom-document-envoye-tab">
                                        @livewire('back.document.document-list-envoyer')
                                    </div>
                                    <div class="tab-pane fade" id="custom-document-recu" role="tabpanel" aria-labelledby="custom-document-recu-tab">
                                        @livewire('back.document.document-list-lu')  
                                    </div>
                                    <!-- <div class="tab-pane fade" id="custom-document-traite" role="tabpanel" aria-labelledby="custom-document-traite-tab">
                                        Documents traités
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
            if ($.fn.DataTable.isDataTable('#liste_document')) {
                $('#liste_document').DataTable().destroy();
            }
            var oTable = $('#liste_document').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.document', $user_id) !!}",
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

            if ($.fn.DataTable.isDataTable('#liste_document_lu')) {
                $('#liste_document_lu').DataTable().destroy();
            }
            var oTable = $('#liste_document_lu').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.document.lu', $user_id) !!}",
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

            if ($.fn.DataTable.isDataTable('#liste_document_envoyer')) {
                $('#liste_document_envoyer').DataTable().destroy();
            }
            var oTable = $('#liste_document_envoyer').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.document.envoyer', $user_id) !!}",
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