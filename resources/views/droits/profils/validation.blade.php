<div class="container" style="padding-bottom: 2em; padding-top: 1em">
        <!-- include('layouts.flash-message') -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <table class="table table-striped nowrap" id="liste_utilisateur">
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



@section('footer')
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  -->
    <script>
        $(document).ready(function(){
            // alert('sa marche');
            $('#liste_utilisateur').DataTable({
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