<div>
    <div class="row" style="padding-top:1em">
        <div class="col-sm-2">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
            </button> -->
            <a class="btn btn-primary" href="/demande/attestation" wire:navigate><i class="fa-solid fa-share-from-square"></i></a>
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
                    <div class="form-group">
                        <button wire:click="envoyerDemandeAttestation()" class="btn btn-lg form-control btn-success">
                            <i class="fa-solid fa-paper-plane"></i> Envoyer une demande
                        </button>
                    </div>
                </div>
                        <!-- end card body -->
            </div>
        </div>
    </div>
    <!-- End Modal AddForm -->


    <br>
    <div class="row">
        <table class="table table-striped nowrap" id="liste_demande_attestation">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>DATE DE DEMANDE</th> 
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
