@extends('layouts.base2')
@section('title', 'Interface de gestion de profil')
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste de profil</h1> @stop
    <div class="container">
        @include('layouts.flash-message')
        <div class="row layout-spacing">
            <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                </div>
                <!-- /.card-header -->
                @include('sweetalert::alert')
                
                @livewire('back.profil.profil-create')
                <!-- /.card-body -->
            </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <script>
        var oTable = $('#listeprofil').DataTable({
                processing: true,
                serverSide: true,
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                language: { "url" :" {!! url("langue/datatable/French.json") !!}"},
                ajax:  '{!! route( 'importer.listedeprofil') !!}',
                columns: [
                    {data: 'numero', name: 'numero'},
                    {data: 'statut', name: 'statut'},
                    {data: 'actions', name: 'actions'},
                ],
                order: [
                    [3, 'desc'] 
                ]
            });
    </script>
@stop