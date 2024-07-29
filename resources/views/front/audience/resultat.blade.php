@extends('layouts.base2')
@section('title', "Resultat de recherche d'une audience")
@section('content')
    @section('titlePage')  <h1 class="m-0">Je trouve une audience sur {{ config('app.name') }}</h1> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')
        
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-6 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/img/resultat.png') }}" style="height: 20em;" alt="resultat">
                        </div>
                        <div class="col-sm-6 d-flex flex-column justify-content-center" style="padding-top: 2em; font-size: 1.5em;">
                            Mme/Mll/M. {{ isset($audienceTrouver) ? $audienceTrouver->user->name : "" }} sera présent au 
                            tribunal de {{ isset($audienceTrouver) ? $audienceTrouver->tribunal->nom_tribunal : "" }} 
                            sis à {{ isset($audienceTrouver) ? $audienceTrouver->ville->nom_ville : "" }} pour un client et optimiser 
                            son temps d'audience en proposant ses services aux confrères absents.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('footer')

@stop