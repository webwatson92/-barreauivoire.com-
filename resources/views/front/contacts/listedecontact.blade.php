@extends('layouts.base2')
@section('title', 'Interface de gestion des clients')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des contacts</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Liste des contacts</a>
                                    </li>
                                    <!-- @avocatuser
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" 
                                        role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Mes Favoris</a>
                                    </li>
                                    @endavocatuser -->
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.contact.contact-list')                                    
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
            
            if ($.fn.DataTable.isDataTable('#liste_contact')) {
                $('#liste_contact').DataTable().destroy();
            }
            
            // if ($.fn.DataTable.isDataTable('#liste_contact_favoris')) {
            //     $('#liste_contact_favoris').DataTable().destroy();
            // }

            var oTable = $('#liste_contact').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.contact') !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'nom', name: 'nom', searchable: true },
                    { data: 'matricule', name: 'matricule', searchable: true },
                    { data: 'tel', name: 'tel', searchable: true },
                    { data: 'email', name: 'email', searchable: true },
                    // { data: 'action', name: 'action', searchable: false }
                ]
            });

            // var oTable =  $('#liste_contact_favoris').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: "{!! route('charger.liste.contact.favoris') !!}",
            //     columns: [
            //         { data: 'numero', name: 'numero' },
            //         { data: 'nom', name: 'nom', searchable: true },
            //         { data: 'matricule', name: 'matricule', searchable: true },
            //         { data: 'tel', name: 'tel', searchable: true },
            //         { data: 'email', name: 'email', searchable: true },
            //         { data: 'action', name: 'action', searchable: false }
            //     ]
            // });

        });

        /**
         * Pour le chargement des actions de mise à jour et suppression
         */
        
    </script>

@stop