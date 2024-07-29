@extends('layouts.base')
@section('title', 'Interface de gestion de code')
@section('content')
    @section('titlePage')  <h1 class="m-0">Liste des codes d'inscription</h1> @stop
    <div class="container">
        @include('layouts.flash-message')
        <div class="row layout-spacing">
            <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Code</h3>
                </div>
                <!-- /.card-header -->
                @include('sweetalert::alert')
    
                @livewire('back.gestion-de-code')
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
                ajax:  '{!! route( 'importer.listedeprofil') !!}',
                columns: [
                    {data: 'numero', name: 'numero'},
                    {data: 'statut', name: 'statut'},
                    {data: 'actions', name: 'actions'},
                ], 
                language: { "url" :" {!! url("langue/datatable/French.json") !!}"},
                order: [
                    [3, 'desc'] 
                ]
            });
    </script>
@stop