<div>
    <div class="row" style="padding-top:1em">
    <div class="col-sm-2">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
            </button> -->
            <a class="btn btn-primary" href="/enregistrer/une/salle" wire:navigate><i class="fa-solid fa-share-from-square"></i></a>
        </div>
        <div class="col-sm-10">
        </div>
    </div>
    
    <!-- Modal AddForm -->
    <div wire:ignore style="padding-bottom; padding-top: 1em" class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Enregistrement d'une salle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save" autocomplete="on" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="padding-top: 1em">
                                    <div class="col-sm-12">
                                        <div class="form-group"  wire:ignore>
                                            <label for="nom">Image </label>
                                            <input required="required" type="file" class="form-control" wire:model="image"> 
                                            <span class="text-danger">@error('image'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 1em">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input required="required" type="text" class="form-control" wire:model="nom" placeholder="Nom de la salle"> 
                                            <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 1em">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea required="required" class="form-control" wire:model="description" placeholder="description de la salle"></textarea>
                                            <span class="text-danger">@error('description'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="capacite">Capacite</label>
                                            <input required="required" type="text" class="form-control" wire:model="capacite" placeholder="200 places"> 
                                            <span class="text-danger">@error('capacite'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lieu">Lieu *</label>
                                            <input type="text" required="required" class="form-control" wire:model="lieu" placeholder="Abidjan"> 
                                            <input type="hidden" id="country-code" name="country_code" class="form-control">
                                            <span class="text-danger">@error('lieu'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="disponibilite">Disponibilité</label>
                                            <select wire:model="etat_qualificatif_id" class="form-control">
                                                <option>Choissisez une option</option>
                                                <option value="7">Libre</option>
                                                <option value="8">Occuper</option>
                                            </select>
                                            <span class="text-danger">@error('etat_qualitatif_id'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="cout">Coût (FCFA)*</label>
                                            <input type="text" required="required" class="form-control" wire:model="cout" placeholder="200000"> 
                                            <span class="text-danger">@error('cout'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="padding-top: 1em">
                                    <button type="submit" class="btn btn-lg form-control btn-success">Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
    <!-- End Modal AddForm -->

    <!-- Modal DeleteForm -->
    <div class="modal fade" id="modalFormDelete" tabindex="-1" aria-labelledby="modalFormDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormDeleteLabel">Suppression du numéro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Etes-vous sûr de vouloir supprimer ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Non</button>
                    <button wire:click="delete" class="btn btn-primary">Oui</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal DeleteForm -->

    <br>
    <div class="row">
        <div class="col-sm-12">
            <div class="row"></div>
            <div class="white_card_body">
                <div class="QA_table table-responsive">
                    <table class="table table-striped nowrap" id="liste_salle">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>IMAGE</th>
                                <th>NOM</th> 
                                <th>DESCRIPTION</th> 
                                <th>CAPACITE</th> 
                                <th>LIEU</th> 
                                <th>DISPONIBILITE</th> 
                                <th>COUT</th> 
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>

    </script>
    </div>
    @endpush

</div>
