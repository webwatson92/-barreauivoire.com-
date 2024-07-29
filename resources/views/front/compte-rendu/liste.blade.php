@extends('layouts.base2')
@section('title', 'Interface ajout de compte rendu')

@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des comptes rendus</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Listes des comptes rendus</a>
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
                                            <table class="table table-striped nowrap" id="liste_compterendu">
                                                <thead>
                                                    <tr>
                                                        <th>Numéro</th>
                                                        <th>NOM FICHIER</th> 
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
@stop
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un compte rendu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('creer.compterendu') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nom_fichier">Nom du fichier</label>
                                <input type="text" class="form-control" name="nom_fichier" id="nom_fichier"
                                    placeholder="Donnez un nom au fichier">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fichier_scanner">Fichier scanné</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="fichier_scanner"
                                            id="fichier_scanner">
                                        <label class="custom-file-label" for="fichier_scanner">Choisir un document
                                            PDF</label>
                                    </div>
                                </div>
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
@section('footer')

    <script>

        $(document).ready(function(){
            if ($.fn.DataTable.isDataTable('#liste_compterendu')) {
                $('#liste_compterendu').DataTable().destroy();
            }
            var oTable = $('#liste_compterendu').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.compterendu') !!}",
                columns: [
                    {data: 'numero',name: 'numero'},
                    {data: 'nomFichier', name: 'nomFichier', searchable: true},
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

                @error('fichier_scanner')
                    setTimeout(function() {
                        Toast.fire({
                            icon: 'error',
                            title: '{{ $message }}'
                        });
                    });
                @enderror

                @error('nom_fichier')
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