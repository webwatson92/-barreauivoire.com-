<div>
    <div class="row" style="padding-top:1em">
        <div class="col-sm-2">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
            </button> -->
            <a class="btn btn-primary" href="/envoyer/un/courrier" wire:navigate><i class="fa-solid fa-share-from-square"></i></a>
        </div>
        <div class="col-sm-10">
            
        </div>
    </div>
    
    <!-- Modal AddForm -->
    <div style="padding-bottom: 2em; padding-top: 1em" class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Envoyer un courrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save" autocomplete="on">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-12" style="padding-bottom:1em">
                                        <div class="form-group">
                                            <label for="titre"><b>Titre du courrier</b></label>
                                            <input required="required" type="text" class="form-control" wire:model="titre" placeholder="Titre du courrier"> 
                                            <span class="text-danger">@error('titre'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="padding-bottom:1em">
                                        <div class="form-group">
                                            <label for="titre"><b>Matricule</b></label>
                                            <input required="required" type="text" class="form-control" wire:model="matricule" id="matricule-input" placeholder="Saisir son matricule">
                                        </div>
                                    </div>
                                    @if($nomComplet)
                                        <div class="col-sm-12" style="padding-bottom:1em">
                                            <div class="form-group">
                                                <label for="nomComplet"><b>Nom complet du destinataire</b></label>
                                                <input type="text" disabled class="form-control" value="{{ $nomComplet }}">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-12" style="padding-bottom:1em">
                                        <div class="form-group">
                                            <label for="contenu"><b>Importer le fichier (Format: PDF)</b></label>
                                            <input type="file" wire:model="contenu" id="fichier">
                                            <span class="text-danger">@error('contenu'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="padding-bottom:1em">
                                        <div class="form-group">
                                            <label for="tel"><b>Traiter avant la date du</b> </label>
                                            <input type="date" required="required" wire:model="date_cloture" id="dateMask" class="form-control input-md" max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"> 
                                            <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg form-control btn-success">
                                        <i class="fa-solid fa-paper-plane"></i> Envoyer
                                        <div wire:loading>
                                            <svg>...</svg> <!-- SVG loading spinner -->
                                        </div>
                                    </button>
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
        <table class="table table-striped nowrap" id="liste_document">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>TYPE</th>
                        <th>TITRE</th>
                        <th>NOM DU FICHIER</th> 
                        <th>DATE DE CLOTURE</th> 
                        <th>SOURCE</th> 
                        <th>ETAT</th> 
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
