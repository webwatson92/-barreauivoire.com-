@extends('layouts.base2')
@section('title', 'Interface de gestion des audiences')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des audiences</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes de mes audiences</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @livewire('front.audience.audience-list')                                    
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

        $(document).ready(function() {
            console.log('Document is ready');
            
            if ($.fn.DataTable.isDataTable('#liste_audience')) {
                $('#liste_audience').DataTable().destroy();
            }

            var oTable = $('#liste_audience').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.audience') !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { 
                        data: 'audience', 
                        name: 'audience',
                        render: function(data, type, row) {
                            return data.replace(/\n/g, '<br>');
                        } 
                    },  
                    { data: 'tribunal', name: 'tribunal' }, 
                    { data: 'ville', name: 'ville' }, 
                    { data: 'date_conseil', name: 'date_conseil', searchable: true },
                    { data: 'heure_debut', name: 'heure_debut', searchable: true },
                    { data: 'heure_fin', name: 'heure_fin', searchable: true },
                    { data: 'action', name: 'action', searchable: false, orderable: false },
                ],

                destroy: true
            });

            console.log("DataTable initialized");

            setInterval(function() {
                location.reload();
            }, 300000); // Tous les cinq minutes

            // Pré-remplir le modal avec les données existantes
            $('#modal-ajout').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); 
                var id = button.data('id');
                var audience = button.data('audience');
                var tribunal_id = button.data('tribunal_id');
                var ville_id = button.data('ville_id');
                var date_conseil = button.data('date_conseil');
                var heure_debut = button.data('heure_debut');
                var heure_fin = button.data('heure_fin');

                var modal = $(this);
                if (id) { // Modification
                    modal.find('.modal-title').text('Modifier audience');
                    modal.find('form').attr('action', '/modifier/audience/' + id);
                } else { // Ajout
                    modal.find('.modal-title').text('Nouveau audience');
                    modal.find('form').attr('action', '{{ route('ajouter.audience') }}');
                }
                modal.find('textarea[name="audience"]').val(audience);
                modal.find('select[name="tribunal_id"]').val(tribunal_id);
                modal.find('select[name="ville_id"]').val(ville_id);
                modal.find('input[name="date_conseil"]').val(date_conseil);
                modal.find('input[name="heure_debut"]').val(heure_debut);
                modal.find('input[name="heure_fin"]').val(heure_fin);
            });

            // Réinitialiser le modal lorsque fermé
            $('#modal-ajout').on('hidden.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title').text('Nouvelle audience');
                modal.find('form').attr('action', '{{ route('ajouter.audience') }}');
                modal.find('textarea[name="audience"]').val('');
                modal.find('select[name="tribunal_id"]').val('');
                modal.find('select[name="ville_id"]').val('');
                modal.find('input[name="date_conseil"]').val('');
                modal.find('input[name="heure_debut"]').val('');
                modal.find('input[name="heure_fin"]').val('');
            });

            //reset modal pour suppression
            $('#liste_tribunaux tbody').on('click', 'button[data-toggle="modal"]', function () {
                var target = $(this).data('target');
                $(target).modal('show');
            });

            // TRAITEMENT DU FORMULAIRE
            $('#form-ajout-audience').on('submit', function(event) {
                event.preventDefault(); // Empêche la soumission normale du formulaire
                var form = $(this);
                var submitButton = form.find('button[type="submit"]');

                // Désactiver le bouton de soumission pour éviter les soumissions multiples
                submitButton.prop('disabled', true);

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Si la requête réussit, vous pouvez fermer la modal et rafraîchir la table DataTables
                        $('#modal-ajout').modal('hide');
                        // $('#liste_audience').DataTable().ajax.reload();
                        window.location.reload();
                        // Réactiver le bouton de soumission
                        submitButton.prop('disabled', false);
                        // Afficher un message de succès, si nécessaire
                    },
                    error: function(response) {
                        // Réinitialiser les messages d'erreur
                        $('.text-danger').html('');
                        
                        if(response.status === 422) {
                            var errors = response.responseJSON.errors;
                            for(var key in errors) {
                                $('#' + key + '-error').html(errors[key][0]);
                            }
                        }
                        // Réactiver le bouton de soumission
                        submitButton.prop('disabled', false);
                    }
                });
            });

            // Fermer le modal en réinitialisant les messages d'erreur et le formulaire
            $('#modal-ajout').on('hidden.bs.modal', function () {
                $('.text-danger').html('');
                $('#form-ajout-audience')[0].reset();
            });
        });

        
    </script>

@stop