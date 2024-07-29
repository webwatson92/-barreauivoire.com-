<div>
    <br>
    <div class="row">
        <h2>Renseignez ici l'audience pour laquelle vous cherchez un confrère </h2>
    </div>
    <br>
    <form method="POST" action="{{ route('rechercher.audience') }}" id="form-ajout-audience">
        @csrf
        <!-- <div class="row">
            @include('layouts.flash-message')
        </div> -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ville_id">Ville du tribunal <span style="color:red">*</span></label>
                    <select name="ville_id" id="ville_id" class="form-control">
                        @foreach($villes as $item)
                            <option class="form-control" value="{{ $item->id }}">{{ $item->nom_ville }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="date_conseil">Date d'audience <span style="color:red">*</span></label>
                    <select name="date_conseil" id="date_conseil" class="form-control">
                        @foreach($audiences as $item)
                            <option class="form-control" value="{{ $item->date_conseil }}">{{ \Carbon\Carbon::parse($item->date_conseil)->format('d/m/Y') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="tribunal_id">Tribunal<span style="color:red">*</span></label>
                    <select name="tribunal_id" id="tribunal_id" class="form-control">
                        @foreach($tribunaux as $item)
                            <option class="form-control" value="{{ $item->id }}">{{ $item->nom_tribunal }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="nom_audience">Plage horaire <span style="color:red">*</span></label>
                    <select name="tribunal_id" id="tribunal_id" class="form-control">
                        @foreach($audiences as $item)
                            <option class="form-control" value="{{ $item->heure_debut }}-{{ $item->heure_fin }}">{{ \Carbon\Carbon::parse($item->heure_debut)->format('H:i') }}H - {{ \Carbon\Carbon::parse($item->heure_fin)->format('H:i') }}H</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-6">
                <a type="button text-left" href="{{route('vue.liste.audience') }}" class="btn btn-danger form-control" data-dismiss="modal"><i class="fa fa-reply"></i> Retour</a>
            </div>
            <div class="col-sm-6 text-right">
                <button type="submit" class="btn btn-success form-control"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</button>
            </div>
        </div>
    </form>

    @push('scripts')
        
    @endpush

</div>
