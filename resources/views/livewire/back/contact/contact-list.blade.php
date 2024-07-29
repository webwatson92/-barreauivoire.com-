<div>
    
    
    <!-- Modal AddForm -->
    <div style="padding-bottom: 2em; padding-top: 1em" class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Enregistrement d'un numéro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save" autocomplete="on">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="padding-bottom: 2em; padding-top: 1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nom">Nom & prénom </label>
                                            <input required="required" type="text" class="form-control" wire:model="nom" placeholder="nom"> 
                                            <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="tel">Numéro de téléphone *</label>
                                            <input id="phone" type="tel" required="required" class="form-control" wire:model="tel" placeholder="Numéro de téléphone"> 
                                            <input type="hidden" id="country-code" name="country_code" class="form-control">
                                            <span class="text-danger">@error('tel'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="form-group">
                                        <label for="tel">Email</label>
                                        <input type="email" required="required" class="form-control" wire:model="email" placeholder="Numéro de téléphone"> 
                                        <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg form-control btn-success">Envoyer</button>
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
                    <button wire:click="delete" class="btn btn-primary" data-bs-dismiss="modal">Oui</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal DeleteForm -->

    <br>
    <div class="row">
        <table class="table table-striped nowrap" id="liste_contact">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>NOM PRENOM</th>
                                <th>MATRICULE</th>
                                <th>TELEPHONE</th> 
                                <th>EMAIL</th> 
                                <!-- <th>ACTIONS</th> -->
                            </tr>
                        </thead>
                        <tbody></tbody>
        </table>
    </div>

    @push('scripts')
    <script>

    </script>
    </div>
    @endpush

</div>
