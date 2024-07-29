@extends('layouts.base2')
@section('title', "Interface ajout d'évènement")

@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des évènements</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Liste des évènements</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        @admin
                                            <div class="row" style="padding-top:1em">
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa-solid fa-plus"></i></button>
                                                </div>
                                            </div>
                                        @endadmin
                                        <br>
                                        <div class="row">
                                            <table class="table table-striped nowrap" id="liste_event">
                                                <thead>
                                                    <tr>
                                                        <th>Numéro</th>
                                                        <th>NOM</th> 
                                                        <th>Lieu</th> 
                                                        <th>DATE D'AJOUT</th> 
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un évènement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('evenement.create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom"
                                    placeholder="Nom de l'évènement">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="lieu">Lieu</label>
                                <input type="text" class="form-control" name="lieu" id="lieu"
                                    placeholder="Lieu de l'évènement">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i> Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop
@section('footer')

    <script>

        $(document).ready(function(){
            if ($.fn.DataTable.isDataTable('#liste_event')) {
                $('#liste_event').DataTable().destroy();
            }
            var oTable = $('#liste_event').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.evenement') !!}",
                columns: [
                    {data: 'numero',name: 'numero'},
                    {data: 'nom', name: 'nom', searchable: true},
                    {data: 'lieu', name: 'lieu', searchable: true},
                    {data: 'dateAjout', name: 'dateAjout', searchable: true},
                    {data: 'action', name: 'action', searchable: false}
                ]
            });
        });

        //Gestion des erreurs
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500
            });

            $('.swalDefaultWarning').ready(function() {
                @if (session('warning'))
                    Toast.fire({
                        icon: 'warning',
                        title: '{{ session('warning') }}'
                    })
                @endif
            });

            $('.swalDefaultSuccess').ready(function() {
                @if (session('status'))
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('status') }}'
                    })
                @endif
            });

            $(document).ready(function() {

                @error('nom')
                    setTimeout(function() {
                        Toast.fire({
                            icon: 'error',
                            title: '{{ $message }}'
                        });
                    });
                @enderror

                @error('lieu')
                    setTimeout(function() {
                        Toast.fire({
                            icon: 'error',
                            title: '{{ $message }}'
                        });
                    }, 2000);
                @enderror

            });


        });
        
    </script>

@stop