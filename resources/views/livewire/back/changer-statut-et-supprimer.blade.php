<div class="card-body">
            @if(Session::has('message'))
                <div class="allert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
            @endif
            <div class="row">
                <div class="col-sm-6" style="padding-bottom:1em">
                    <a class="btn btn-danger" href="{{ route('vue.listedesparametre') }}"><i class="fa fa-reply" aria-hidden="true"></i> RETOUR</a>
                </div>
                <div class="col-sm-6" style="padding-bottom:1em;">
                    <button type="button" style="margin-bottom:5px;" class="btn btn-primary" data-toggle="modal" 
                    data-target="#exampleModal" data-whatever="@getbootstrap"><i class="fa fa-add" aria-hidden="true"></i>
                        AJOUTER UN PROFIL
                    </button>
                    <!-- <button wire:click="$emit('openModal', 'profils.create')" class="btn btn-primary">Nouveau Profil</button> -->
                </div>
            </div>
            <!-- <button type="button" style="margin-bottom:5px;" class="btn btn-primary" data-toggle="modal" 
                data-target="#exampleModal" data-whatever="@getbootstrap"><i class="fa fa-add" aria-hidden="true"></i></button> -->
    <table id="listeprofil" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>N°</th>
                <th>LIBELLE</th>
                <th>STATUT</th>
                <th>ROUTE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; ?>
            @foreach($tousLesProfils as $item)
            <tr>
                <td><?php $i++ ?></td>
                <td>{{ $item->libelle }}</td>
                <td>{{ $item->statut == 0 ? "Inactif" : "Actif" }}</td>
                <td>{{ $item->route }}</td>
                <td>
                    <span type="button" wire:click="changerStatut({{ $item->id }})" class="btn btn-warning"> <i class="fa fa-pencil" aria-hidden="true"></i>
                    </span>
                    <span type="button" wire:click="supprimerProfil({{ $item->id }})" class="btn btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i>
                    </span>
                </td>
            </tr>
            @endforeach
        <tbody>
    </table>
    <div class="mt-3">
        {{ $tousLesProfils->links() }}
    </div>


    
<div wire:ignore class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLabel">Ajouter un profil</h2>
            @if(Session::get('success'))
                <div class="p-5">
                    <div class="block p-2 bg-green-500 text-white rounded-sm shadow-sm mt-2"> {{ Session::get('success') }}</div>
                </div>
            @endif
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form wire:submit.prevent="ajouterProfil()">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="libelle" class="col-form-label">Libelle</label>
                        <input type="text" wire:model="libelle" class="form-control" id="libelle">
                        @error('libelle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="route" class="col-form-label">Route</label>
                        <input type="text" wire:model="route" class="form-control" id="route">
                        @error('route')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>