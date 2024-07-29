<div>
    <form wire:submit.prevent="update" autocomplete="off">
        <div class="card col-sm-6">
            <div class="card-header card-primary"></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nom">Nom & prénom </label>
                        <input required="required" type="text" class="form-control" value="{{ $contact->nom }}" wire:model="nom" placeholder="Nom & prénom"> 
                        <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="tel">Numéro de téléphone *</label> <br>
                        <input id="phone" type="tel" required="required" value="{{ $contact->tel }}" class="form-control" wire:model="tel" placeholder="Numéro de téléphone"> 
                        <input type="hidden" id="country-code" name="country_code" class="form-control">
                        <span class="text-danger">@error('tel'){{$message}} @enderror</span>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="tel">Email</label>
                            <input type="email" required="required" class="form-control" wire:model="email" placeholder="Numéro de téléphone"> 
                            <span class="text-danger">@error('email'){{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="form-group" style="padding-bottom: 2em; padding-top: 1em">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="/liste/de/contact" wire:navigate class="btn btn-danger"><i class="fa fa-reply"></i> RETOUR</a>
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
