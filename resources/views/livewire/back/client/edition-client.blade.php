<div>
    <form wire:submit.prevent="update" autocomplete="on">
        <div class="card col-sm-6">
            <div class="card-header card-primary"></div>
                <div class="card-body">
                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input required="required" value="{{ $client->code }}" type="text" class="form-control" wire:model="code" placeholder="code"> 
                                            <span class="text-danger">@error('code'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="nom" value="{{ $client->nom }}" required="required" class="form-control" wire:model="nom" placeholder="Nom & prénom"> 
                                            <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input value="{{ $client->adresse }}" required="required" type="text" class="form-control" wire:model="adresse" placeholder="Une adresse"> 
                                            <span class="text-danger">@error('adresse'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input value="{{ $client->tel }}" id="phone" type="tel" required="required" class="form-control" wire:model="tel" placeholder="Numéro de téléphone"> 
                                            <input type="hidden" id="country-code" name="country_code" class="form-control">
                                            <span class="text-danger">@error('tel'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom:1em">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input value="{{ $client->source }}" required="required" type="text" class="form-control" wire:model="source" placeholder="Personne ressource"> 
                                            <span class="text-danger">@error('source'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input value="{{ $client->montant }}" id="montant" type="montant" required="required" class="form-control" wire:model="montant" placeholder="Montant"> 
                                            <span class="text-danger">@error('montant'){{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                    <div class="form-group" style="padding-bottom: 2em; padding-top: 1em">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="/liste/de/client" wire:navigate class="btn btn-danger"><i class="fa fa-reply"></i> RETOUR</a>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn form-control btn-success"><i class="fa fa-save"></i> SOUMETTRE</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
