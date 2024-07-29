<div class="row" style="padding-bottom: 2em; padding-top: 1em">
    <div class="col-md-3">
        <a href="{{ route('admin.vue.creation.utilisateur') }}"  class="btn  btn-primary"  style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Ajouter Un Utilisateur</a>

    </div>
    
</div>

<div class="">
        <!-- include('layouts.flash-message') -->
            <table class="table table-striped nowrap" id="liste_utilisateur">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>NOM PRENOM</th>
                        <th>EMAIL</th>
                        <th>DATE NAISSANCE</th>
                        <th>SEXE</th>
                        <th>TEL</th> 
                        <th>NUM TOGE</th> 
                        <th>PROFIL</th> 
                         <th>ACTIONS</th>
                        <!-- <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th> -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
 </div>



@section('footer')

    <script>

        $(document).ready(function(){
            // alert('sa marchesss');
             
            if ($.fn.DataTable.isDataTable('#liste_utilisateur')) {
                $('#liste_utilisateur').DataTable().destroy();
            }
            
            $('#liste_utilisateur').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('admin.liste.utilisateurs') !!}",
                columns: [
                    { data: 'numero', name: 'numero' },
                    { data: 'nom_prenom', name: 'nom_prenom' },
                    { data: 'email', name: 'email' },
                    { data: 'date_naissance', name: 'date_naissance' },
                    { data: 'sexe', name: 'sexe' },
                    { data: 'telephone', name: 'telephone' },
                    { data: 'num_toge', name: 'num_toge' },
                    { data: 'profil', name: 'profil' },
                    { data: 'action', name: 'action' }
                ]
            });

            $('.delete-button').on('click', function(e) {
                e.preventDefault(); 
                
                var userId = $(this).data('id');
                
                if (confirm("Voulez-vous vraiment supprimer cette ligne ?")) {
                    window.location.href = $(this).attr('href');
                }

            });
        
    });
    </script>
@endsection