@extends('layouts.base2')
@section('title', "Interface de demandes d'attestation")
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="">Liste des demandes d'attestation</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes des demandes</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @if($user->role === "superadmin" || $user->role === "admin" || $user->role === "barreau")
                                            @livewire('back.demandeattestation.demande-list-admin')  
                                        @else
                                            @livewire('back.demandeattestation.demande-list')  
                                        @endif                                  
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
            if ($.fn.DataTable.isDataTable('#liste_demande_attestation')) {
                $('#liste_demande_attestation').DataTable().destroy();
            }
            var oTable = $('#liste_demande_attestation').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.demande.attestation', $userId) !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'date_demande', name: 'date_demande'},
                    { data: 'etat', name: 'etat'},
                    { data: 'action', name: 'action'},
                ]
            });

            if ($.fn.DataTable.isDataTable('#liste_demande_attestation_admin')) {
                $('#liste_demande_attestation_admin').DataTable().destroy();
            }
            var oTable = $('#liste_demande_attestation_admin').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.demande.attestation.admin', $userId) !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'date_demande', name: 'date_demande'},
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