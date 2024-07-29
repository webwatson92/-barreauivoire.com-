@extends('layouts.base2')

@section('content')
    @section('titlePage')  <h3 class="m-0">Les salles du barreau</h3> @stop
    <div class="py-12">
        <div class="row">
            @foreach($salle as $s)
                <div class="col-sm-4">
                    <div class="card shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225"  role="img" aria-label="Placeholder: {{ $s->nom }}" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">{{ $s->nom }}</text></svg>
                        <div class="card-body">
                        <p class="card-text" style="padding-top:1em">Description : {{ $s->description }}</p>
                        <p class="card-text" style="padding-top:1em">Lieu : {{ $s->lieu }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Capacité : {{ $s->capacite }}</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Coût : {{ $s->cout }} FCFA</button>
                            </div>
                            <small class="btn btn-danger btn-sm" style="margin:5px">Statut : {{ $s->etat_qualificatif_id == 7 ? "Libre" : "Occuper" }}</small>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-3">
                    <div class="card">
                        <div class="card-header">
                            <h1></h1>
                        </div>
                        <div class="card-body">
                                <img src="" alt="">
                            </div>
                            <div class="content">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-footer"  style="background-color: blue">
                            <div class="row">
                                <div class="col-sm-6" style="color: #fff;font-weight:bold">Coût : {{ $s->cout }} F</div>
                                <div class="col-sm-6" style="color: #fff;font-weight:bold"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
            @endforeach
        </div>
    </div>
@stop

