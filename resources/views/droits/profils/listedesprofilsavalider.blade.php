@extends('layouts.base2')
@section('title', 'Interface de gestion de droit')
@section('content')
    @section('titlePage')  <h1 class="m-0">Interface de validation</h1> @stop
    <div class="container">
        <!-- include('layouts.flash-message') -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-striped nowrap" id="list_user_validation">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>PRENOM</th>
                                    <th>DATE NAISSANCE</th>
                                    <th>LIEU DE FONCTION</th>
                                    <th>STATUT</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
@stop


@section('footer')
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  -->
    <script>
        $(document).ready(function(){
            if ($.fn.DataTable.isDataTable('#list_user_validation')) {
                $('#list_user_validation').DataTable().destroy();
            }

            var oTable = $('#list_user_validation').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('admin.charger.liste.validation') !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'prenom', name: 'prenom' },
                    { data: 'date_naissance', name: 'date_naissance' },
                    { data: 'lieu_structure', name: 'lieu_structure' },
                    { data: 'etat', name: 'etat' },
                    { data: 'action', name: 'action' }
                ],
                searching: true 
            });
            
        });
    </script>
@stop