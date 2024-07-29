@extends('layouts.base2')
@section('title', 'Interface de gestion de droit')
@section('content')
    @section('titlePage')  <h1 class="m-0">Gestion des droits</h1> @stop
    <div class="container">
        <!-- include('layouts.flash-message') -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" 
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">GESTION DES UTISATEURS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" 
                                        role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">GESTION DE PROFIL</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-parcours-tab" data-toggle="pill" href="#custom-tabs-one-parcours" 
                                        role="tab" aria-controls="custom-tabs-one-parcours" aria-selected="false">VALIDATIONS</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @include('droits.utilisateurs.index')                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        @include('droits.profils.index')                                      
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-parcours" role="tabpanel" aria-labelledby="custom-tabs-one-parcours-tab">
                                        @include('droits.profils.validation')                                      
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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  -->
    <script>
        $(document).ready(function(){
            alert('sa marche');

            // $("#dateMask").inputmask("dd/mm/yyyy", {"placeholder": "dd-mm-yyyy"});

            // var dateFinInput = $('#dateMask');

            // dateFinInput.on('input', function() {
            //     var currentDate = new Date(); // Obtenir la date actuelle

            //     // Limite supérieure fixée à la date actuelle
            //     var maxYear = currentDate.getFullYear();
            //     var maxMonth = currentDate.getMonth() + 1; // Les mois sont indexés à partir de 0, donc on ajoute 1
            //     var maxDay = currentDate.getDate();

            //     // Formater la date actuelle dans le format 'YYYY-MM-DD'
            //     var maxDate = maxYear + '-' + (maxMonth < 10 ? '0' + maxMonth : maxMonth) + '-' + (maxDay < 10 ? '0' + maxDay : maxDay);

            //     var selectedDate = $(this).val();
                
            //     // Vérifier si la date sélectionnée est postérieure à la date actuelle
            //     if (selectedDate > maxDate) {
            //         alert('La date ne peut pas être postérieure à aujourd\'hui.');
            //         $(this).val(''); // Réinitialiser la valeur du champ
            //     }
            // });
        })
    </script>
@stop