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
                    <h4 class="modal-title">Nouvelle audience</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('ajouter.audience') }}" id="form-ajout-audience">
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nom_audience">Contenu (texte) <span style="color:red">*</span> </label>
                                <textarea name="audience"  class="form-control" id="" cols="5" rows="5"></textarea>
                                <span class="text-danger" id="audience-error"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="tribunal_id">Choisir une tribunal <span style="color:red">*</span></label>
                                <select name="tribunal_id" id="tribunal_id" class="form-control">
                                    @foreach($tribunaux as $item)
                                        <option class="form-control" value="{{ $item->id }}">{{ $item->nom_tribunal }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="tribunal_id-error"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="ville_id">Choisir une ville <span style="color:red">*</span></label>
                                <select name="ville_id" id="ville_id" class="form-control">
                                    @foreach($villes as $item)
                                        <option class="form-control" value="{{ $item->id ?? "" }}">{{ $item->nom_ville }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="ville_id-error"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="nom_audience">Date Conseil <span style="color:red">*</span></label>
                                <input type="date" name="date_conseil" class="form-control"">
                                <span class="text-danger" id="date_conseil-error"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="heure_debut">Heure Début <span style="color:red">*</span></label>
                                <input type="time" name="heure_debut" class="form-control"">
                                <span class="text-danger" id="heure_debut-error"></span>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="heure_fin">Heure Fin <span style="color:red">*</span></label>
                                <input type="time" name="heure_fin" class="form-control"">
                                <span class="text-danger" id="heure_fin-error"></span>
                            </div>
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
        <table class="table table-striped nowrap" id="liste_audience">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>AUDIENCE</th> 
                    <th>TRIBUNAL</th> 
                     <th>VILLE</th> 
                    <th>DATE CONSEIL</th> 
                    <th>HEURE DEBUT</th> 
                     <th>HEURE FIN</th> 
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


    @push('scripts')
        
    @endpush

</div>
