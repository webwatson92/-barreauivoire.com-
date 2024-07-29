<div>
    <div class="row" style="padding-top:1em">
        <div class="col-sm-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ajout"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
    
    <!-- Modal Add AddForm -->
    <div class="modal fade" id="modal-ajout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle ville</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('ajouter.ville') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nom_ville">Nom de la ville</label>
                                <input type="text" class="form-control" name="nom_ville" id="nom_ville" placeholder="Donnez un nom au fichier">
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i> Fermer</button>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Add AddForm -->

    <br>
    <div class="row">
        <table class="table table-striped nowrap" id="liste_ville">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>VILLE</th> 
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    @push('scripts')
    
    <script>
      
    </script>
    @endpush

</div>
