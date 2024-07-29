@extends('layouts.base2')
@section('title', 'Interface de gestion des tribunaux')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des tribunaux</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes des tribunaux</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('back.tribunal.tribunal-list')                                    
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
            
            if ($.fn.DataTable.isDataTable('#liste_tribunal')) {
                $('#liste_tribunal').DataTable().destroy();
            }
            var oTable = $('#liste_tribunal').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('charger.liste.tribunal') }}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'nom_tribunal', name: 'nom_tribunal'},
                    // { data: 'ville', name: 'ville', searchable: true },
                    { data: 'action', name: 'action', searchable: false }
                ]
            });

            setInterval(function(){
                location.reload();
            }, 300000); //Tous les deux minutes

            // Pré-remplir le modal avec les données existantes
            $('#modal-ajout').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); 
                var id = button.data('id');
                var nom_tribunal = button.data('nom_tribunal');
                // var ville_id = button.data('ville_id');

                var modal = $(this);
                if (id) { // Modification
                    modal.find('.modal-title').text('Modifier tribunal');
                    modal.find('form').attr('action', '/modifier/tribunal/' + id);
                } else { // Ajout
                    modal.find('.modal-title').text('Nouveau tribunal');
                    modal.find('form').attr('action', '{{ route('ajouter.tribunal') }}');
                }
                modal.find('input[name="nom_tribunal"]').val(nom_tribunal);
                // modal.find('select[name="ville_id"]').val(ville_id);
            });

            // Réinitialiser le modal lorsque fermé
            $('#modal-ajout').on('hidden.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title').text('Nouveau tribunal');
                modal.find('form').attr('action', '{{ route('ajouter.tribunal') }}');
                modal.find('input[name="nom_tribunal"]').val('');
                // modal.find('select[name="ville_id"]').val('');
            });

            //reset modal pour suppression
            $('#liste_tribunaux tbody').on('click', 'button[data-toggle="modal"]', function () {
                var target = $(this).data('target');
                $(target).modal('show');
            });
        });

        
    </script>

@stop