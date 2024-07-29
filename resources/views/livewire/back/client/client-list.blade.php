<div>
    <div class="row">
        <div class="col-sm-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
                <i class="fa-solid fa-circle-plus fa-beat"></i>
            </button>
        </div>
        <div class="col-sm-10">
            
        </div>
    </div>
    
    <!-- Modal AddForm -->
    <div style="padding-bottom: 2em; padding-top: 1em" class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Enregistrement d'un client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save" autocomplete="on">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input required="required" type="text" class="form-control" wire:model="code" placeholder="code"> 
                                            <span class="text-danger">@error('code'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="nom" required="required" class="form-control" wire:model="nom" placeholder="Nom & prénom"> 
                                            <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input required="required" type="text" class="form-control" wire:model="adresse" placeholder="Une adresse"> 
                                            <span class="text-danger">@error('adresse'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input id="phone" type="tel" required="required" class="form-control" wire:model="tel" placeholder="Numéro de téléphone"> 
                                            <input type="hidden" id="country-code" name="country_code" class="form-control">
                                            <span class="text-danger">@error('tel'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input required="required" type="text" class="form-control" wire:model="source" placeholder="Personne ressource"> 
                                            <span class="text-danger">@error('source'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input id="montant" type="montant" required="required" class="form-control" wire:model="montant" placeholder="Montant"> 
                                            <span class="text-danger">@error('montant'){{$message}} @enderror</span>
                                        </div>
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
        <div class="col-sm-12">
            <div class="row"></div>
            <div class="white_card_body">
                <div class="QA_table table-responsive">
                    <table class="table table-striped nowrap" id="liste_client">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Code</th>
                                <th>NOM PRENOM</th>
                                <th>Adresse</th>
                                <th>TELEPHONE</th> 
                                <th>Personne ressource</th> 
                                <th>Montant</th> 
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
        document.addEventListener('livewire:load', function () {
            $(document).ready(function () {
                if (!$.fn.DataTable.isDataTable('#liste_client')) {
                    var oTable = $('#liste_client').DataTable({
                        processing: true,
                        serverSide: true,
                        language : { "url": "{!! url("langue/datatable/French.json") !!}"},
                        ajax: {
                            url : "{!! route('charger.liste.client') !!}",
                            data : function(d) {}
                        },
                        columns: [
                            { data: 'numero', name: 'numero' },
                            { data: 'code', name: 'code', searchable: true },
                            { data: 'nom', name: 'nom', searchable: true },
                            { data: 'adresse', name: 'adresse', searchable: true },
                            { data: 'tel', name: 'tel', searchable: true },
                            { data: 'source', name: 'source', searchable: true },
                            { data: 'montant', name: 'montant', searchable: true },
                            { data: 'action', name: 'action', searchable: false }
                        ]
                    });
                }
            });
        });
    </script>
    @endpush

</div>
