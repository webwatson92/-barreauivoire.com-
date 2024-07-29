@extends('layouts.base2')
@section('title', "Interface de Faq")

@section('content')
    @section('titlePage')  <h1 class="m-0">Liste de FAQs</h1> @stop
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
                                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Liste des Questions/Réponses</a>
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
                                            <table class="table table-striped nowrap" id="liste_faq">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>QUESTION</th> 
                                                        <th>REPONSE</th> 
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
                    <h4 class="modal-title">Ajouter FAQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('faq.create') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" class="form-control" name="question" id="Question"
                                    placeholder="Une question">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="reponse">Réponse</label>
                                <textarea name="reponse" id="" rows="5" class="form-control" placeholder="La réponse liée à la question"></textarea>
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
            if ($.fn.DataTable.isDataTable('#liste_faq')) {
                $('#liste_faq').DataTable().destroy();
            }
            var oTable = $('#liste_faq').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('charger.liste.faq') !!}",
                columns: [
                    {data: 'numero',name: 'numero'},
                    {data: 'question', name: 'question', searchable: true},
                    { 
                        data: 'reponse', 
                        name: 'reponse',
                        render: function(data, type, row) {
                            return data.replace(/\n/g, '<br>');
                        } 
                    },
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