@extends('layouts.base2')
@section('title', "Enregistrement d'une salle")
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h3 class="m-0">Modification des informations</h3> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')

        <div class="row col-sm-6">
            <form method="post" action="{{ route('modifier.salle') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="salleid" value="{{ $salleInfo->id }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="padding-top: 1em">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nom">Image </label>
                                    <input required="required" type="file" class="form-control" name="image"> 
                                    <span class="text-danger">@error('image'){{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 1em">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input required="required"  value="{{ $salleInfo->nom }}"  type="text" class="form-control" name="nom" placeholder="Nom de la salle"> 
                                    <span class="text-danger">@error('nom'){{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 1em">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea required="required"  class="form-control" name="description" placeholder="description de la salle">{{ $salleInfo->description }}</textarea>
                                    <span class="text-danger">@error('description'){{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 1em">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="capacite">Capacite</label>
                                    <input required="required"  value="{{ $salleInfo->capacite }}"  type="text" class="form-control" name="capacite" placeholder="200"> 
                                    <span class="text-danger">@error('capacite'){{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lieu">Lieu *</label>
                                    <input type="text"  value="{{ $salleInfo->lieu }}" required="required" class="form-control" name="lieu" placeholder="Abidjan"> 
                                    <span class="text-danger">@error('lieu'){{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 1em">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="disponibilite">Disponibilité</label>
                                    <select  value="{{ $salleInfo->etat_qualificatif_id }}" name="etat_qualificatif_id" class="form-control">
                                        <option>Choissisez une option</option>
                                        <option value="7">Libre</option>
                                        <option value="8">Occuper</option>
                                    </select>
                                    <span class="text-danger">@error('etat_qualitatif_id'){{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cout">Coût (FCFA)*</label>
                                    <input type="text" value="{{ $salleInfo->cout }}"  required="required" class="form-control" name="cout" placeholder="200000"> 
                                    <span class="text-danger">@error('cout'){{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:1em">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <a class="btn btn-danger" href="/liste/de/salle " wire:navigate><i class="fa fa-reply"></i> RETOUR</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button type="submit" class="btn form-control btn-primary">
                                        <i class="fa-solid fa-save"></i> Enregistrer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop
@section('footer')
    <script>
    </script>
@stop