<div class="card-body">
            @if(Session::has('message'))
                <div class="allert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
            @endif
            <div class="row">
                <div class="col-sm-6" style="padding-bottom:1em">
                    <a class="btn btn-danger" href="{{ route('vue.listedesparametre') }}"><i class="fa fa-reply" aria-hidden="true"></i> RETOUR</a>
                </div>
                <div class="col-sm-6" style="padding-bottom:1em">
                    <span type="button" style=""  wire:click="ajouterCode()" class="btn btn-primary"> 
                        <i class="fa fa-add" aria-hidden="true"></i> GENERATION DU CODE D'INSCRIPTION
                    </span>
                </div>
            </div>
    <table id="listeprofil" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>N°</th>
                <th>CODE D'INSCRIPTION</th>
                <th>STATUT</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <!-- <?php $i=1; ?> -->
            @foreach($tousLesCodes as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->code_inscription }}</td>
                <td>{{ $item->expires == 0 ? "Disponible" : "Indisponible" }}</td>
                <td>
                    @if($item->expires == 0)
                        <span type="button" wire:click="changerStatut({{ $item->id }})" class="btn btn-warning"> <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span> 
                        <span type="button" wire:click="supprimerCode({{ $item->id }})" class="btn btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> 
                        </span>
                    @else 
                        Code déjà attribué
                    @endif
                        
                </td>
            </tr>
            @endforeach
        <tbody>
    </table>
    <div class="mt-3">
        {{ $tousLesCodes->links() }}
    </div>



</div>