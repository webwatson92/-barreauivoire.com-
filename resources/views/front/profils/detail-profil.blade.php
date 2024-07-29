@extends('layouts.base2')
@section('title', 'Interface de gestion de profil')
@section('content')
    @section('titlePage')  <h1 class="m-0">Affichage et Modifition du profil</h1> @stop
    <div class="container">
        <!-- include('layouts.flash-message') -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                       <div class="card">
                            <div class="card-body">
                                <div class="row container">
                                    <form action="{{ route('user.modifier.utilisateur', $utilisateurTrouver->id) }}" method="post">
                                        @if(Session::has('message'))
                                            <div class="alert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
                                        @endif
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div style="width:50%;background-color:#3B71CA; height:30px; padding:5px; color:#FBFBFB; font-weight: bold; font-size: 100%;">
                                                    INFORMATION PERSONNELLE
                                                </div>
                                                <div style="width:100%;background-color:#3B71CA; height:3px;margin-bottom:5px;"></div>
                                                <!-- <span style="border: 2px solid blue;width: 100em; height: 20px"></span> -->
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="code" class="control-label">Code (*)</label>
                                                        <input type="text" disabled value="{{ $utilisateurTrouver->code ? $utilisateurTrouver->code : '' }}"  placeholder="Code barreau" name="code" class="form-control">
                                                        @error('code') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="matricule" class="control-label">Matricule (*)</label>
                                                        <input type="text" disabled value="{{ $utilisateurTrouver->matricule ? $utilisateurTrouver->matricule : '' }}"  placeholder="0GD02024" name="matricule" class="form-control">
                                                        @error('matricule') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="name" class="control-label">Nom (*)</label>
                                                        <input type="text" disabled value="{{ $utilisateurTrouver->name ? $utilisateurTrouver->name : '' }}" placeholder="Nom" name="name" class="form-control">
                                                        <input type="hidden"  value="{{ $utilisateurTrouver->name ? $utilisateurTrouver->name : '' }}" placeholder="Nom" name="name" class="form-control">
                                                        @error('name') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="prenom" class="control-label">Prénom (*)</label>
                                                        <input type="text" value="{{ $utilisateurTrouver->prenom ? $utilisateurTrouver->prenom : '' }}"  placeholder="Prénom" name="prenom" class="form-control">
                                                        @error('prenom') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="email" class="control-label">Email (*)</label>
                                                        <input disabled type="email" value="{{ $utilisateurTrouver->email ? $utilisateurTrouver->email : '' }}"  placeholder="Email" name="email" class="form-control">
                                                        <input type="hidden" value="{{ $utilisateurTrouver->email ? $utilisateurTrouver->email : '' }}"  placeholder="Email" name="email" class="form-control">
                                                        @error('email') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="dateMask" class="control-label">Date Naissance (*)</label>
                                                        <input type="date" value="{{ $utilisateurTrouver->date_naissance ? $utilisateurTrouver->date_naissance : '' }}" name="date_naissance" placeholder="JJ/MM/YYYY" id="dateMask" class="form-control">
                                                        @error('date_naissance') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="sexe" class="control-label">Sexe (*)</label>
                                                        <select name="sexe" id="sexe" disabled value="{{ $utilisateurTrouver->sexe ? $utilisateurTrouver->sexe : '' }}" class="form-control">
                                                            <option>Choisissez votre sexe</option>
                                                            <option value="M" {{ $utilisateurTrouver->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                                            <option value="F" {{ $utilisateurTrouver->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                                                        </select>
                                                        @error('sexe') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="telephone" class="control-label">Téléphone (*)</label>
                                                        <input type="text" disabled value="{{ $utilisateurTrouver->telephone ? $utilisateurTrouver->telephone : '' }}" name="telephone" placeholder="(+225) xxxxxxxx" id="telephone" class="form-control">
                                                        @error('telephone') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div style="width:50%;background-color:#3B71CA; height:30px; padding:5px; color:#FBFBFB; font-weight: bold; font-size: 100%;">
                                                    AUTRES INFORMATIONS
                                                </div>
                                                <div style="width:100%;background-color:#3B71CA; height:3px;margin-bottom:5px;"></div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="lieu_structure" class="control-label">Lieu de fonction (*)</label>
                                                        <input type="text" value="{{ $utilisateurTrouver->lieu_structure ? $utilisateurTrouver->lieu_structure : '' }}" name="lieu_structure" placeholder="Abidjan" id="lieu_structure" class="form-control">
                                                        @error('lieu_structure') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="role" class="control-label">Type de Compte (*)</label>
                                                        <select name="role" disabled value="{{ $utilisateurTrouver->role ? $utilisateurTrouver->role : '' }}" class="form-control" id="role">
                                                            <option>Choisissez un profil</option>
                                                            <option value="admin" {{ $utilisateurTrouver->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                            <option value="barreau" {{ $utilisateurTrouver->role == 'barreau' ? 'selected' : '' }}>Barreau</option>
                                                            <option value="avocat" {{ $utilisateurTrouver->role == 'avocat' ? 'selected' : '' }}>Avocat</option>
                                                            <option value="user" {{ $utilisateurTrouver->role == 'user' ? 'selected' : '' }}>Autre</option>
                                                        </select>
                                                        @error('role') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label for="dateMask" class="control-label">Date de prestation</label>
                                                        <input type="date" disabled value="{{ $utilisateurTrouver->date_prestation ? $utilisateurTrouver->date_prestation : '' }}" name="date_prestation" placeholder="JJ/MM/YYYY" id="dateMask" class="form-control">
                                                        @error('date_prestation') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="expertise" class="control-label">Expertise</label>
                                                        <input type="text" value="{{ $utilisateurTrouver->expertise ? $utilisateurTrouver->expertise : '' }}" name="expertise" placeholder="Droit des affaires" id="expertise" class="form-control">
                                                        @error('expertise') <p class="text-danger">{{$message}}</p>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="" style="float:right">
                                            <a class="btn btn-danger" href="{{ route("admin.home") }}"><i class="fa fa-reply"></i> RETOUR</a>
                                            <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-save"></i> SOUMETTRE LA DEMANDE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop


