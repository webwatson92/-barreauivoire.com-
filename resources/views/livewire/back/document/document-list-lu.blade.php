<div>
    <div class="row" style="padding-top:1em">
        <div class="col-sm-2">
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
            </button> -->
            <!-- <a class="btn btn-primary" href="/envoyer/un/document" wire:navigate><i class="fa-solid fa-share-from-square"></i></a> -->
        </div>
        <div class="col-sm-10">
            
        </div>
    </div>
    
    <div class="row">
        <table class="table table-striped nowrap" id="liste_document_lu">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>TYPE</th>
                                <th>TITRE</th>
                                <th>NOM DU FICHIER</th> 
                                <th>DATE DE CLOTURE</th> 
                                <th>SOURCE</th> 
                                <th>ETAT</th> 
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
