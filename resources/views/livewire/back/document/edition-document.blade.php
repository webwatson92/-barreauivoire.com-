<div>
    <form wire:submit.prevent="update" autocomplete="off" enctype="multipart/form-data>
        <div class="card col-sm-6">
            <div class="card-header card-primary"></div>
                <div class="card-body">
                    <div class="row" style="padding-bottom:1em">
                        <div class="col-sm-12" style="padding-bottom:1em">
                            <div class="form-group">
                                <label for="titre"><b>Titre du document</b></label>
                                <input required="required" value="{{ $document->titre }}" wire:model="titre" type="text" class="form-control" name="titre" placeholder="Titre du document"> 
                                <span class="text-danger">@error('titre'){{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-bottom:1em">
                            <div class="form-group">
                                <label for="contenu"><b>Importer le fichier (Format: PDF)</b></label>
                                <input type="file" name="contenu" id="fichier" wire:model="contenu">
                                <span class="text-danger">@error('contenu'){{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="row" style="padding-bottom:1em">
                            <div class="form-group col-sm-6">
                                <label for="tel"><b>Traiter avant la date du</b> </label>
                                <input type="date" value="{{ $document->date_cloture }}" wire:model="date_cloture" required="required" name="date_cloture" id="date_cloture" class="form-control input-md">                                    <span class="text-danger">@error('email'){{$message}} @enderror</span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="tel"><b>Niveau de pertinance</b> </label>
                                <select {{ $document->pertinance }}" wire:model.lazy="pertinance" class="form-control input-md" required="required" required="required">
                                    @foreach($statuts as $statut)
                                        <option value="{{ $statut->titre}}">{{ $statut->titre}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('pertinance'){{$message}} @enderror</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <a class="btn btn-danger" href="/liste/de/document" wire:navigate><i class="fa fa-reply"></i> RETOUR</a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button type="submit" class="btn form-control btn-success">
                                    <i class="fa-solid fa-paper-plane"></i> Envoyer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
