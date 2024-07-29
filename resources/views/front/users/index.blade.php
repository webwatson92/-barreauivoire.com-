@extends('layouts.base2')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #3ade9f; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('evenement.index') }}">{{ $nombreEvenement > 1 ? "Evènements" : "Evènement" }} </a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $nombreEvenement ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #272d69; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('activite.index') }}">{{ $activites > 1 ? "Activités" : "Activité" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $Activites ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #272d69; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('information.index') }}">{{ $informations > 1 ? "Informations" : "Information" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $informations ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card" style="backg-round-color: #272d69; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('vue.liste.document') }}">{{ $courrierEnvoyer > 1 ? "Mes courriers envoyés" : "Mon courrier envoyé" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $courrierEnvoyer ?? 0 }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="card" style="background-color: #fff; font-size:20px;">
                <div class="card-body text-center text-white">
                    <a href="{{ route('vue.liste.document') }}">{{ $courrierRecu > 1 ? "Mes courriers reçu" : "Mon courrier reçu" }}</a>
                </div>
                <div class="card-footer text-center text-white" style="background-color: #272d69">
                    {{ $courrierRecu ?? 0 }}
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
    </div>
        <!-- <div class="row" style="margin-top: 150px;">
            <div class="col-md-2"></div>
            <div class="col-md-2" style="text-align:center;margin: 10em;">
                <a href="{{ route('evenement.index') }}" class="btn btn-primary btn-circle btn-xl last-button">
                    <i class="fa fa-android fa-3x"></i>
                </a>
                <br>
                <p style="margin: 5px; font-weight: bold;">{{ $nombreEvenement > 1 ? "Evènements" : "Evènement" }} 
                    <span style="color: #000; backgroud-color="#fff"> {{ $nombreEvenement ?? 0 }}</span></p>
            </div>
            <div class="col-md-2" style="text-align:center;">
                <a href="{{ route('activite.index') }}" class="btn btn-info btn-circle btn-xl last-button">
                    <i style="font-size: 2em;" class="fa-solid fa-folder-open"></i>
                </a>
                <br>
                <p style="margin: 5px; font-weight: bold;">{{ $activites > 1 ? "Activités" : "Activité" }} 
                    <span style="color: #000; backgroud-color="#fff"> {{ $Activites ?? 0 }}</span></p>
            </div>

            <div class="col-md-2"></div>
        </div> -->

    </div>
@stop
@push('script')
    <script>
        $(function(){
            $("#event").on('click', function(){
                document.location = "{{ route('admin.liste.validation') }}";
            });
            $("#activite").on('click', function(){
                document.location = "{{ route('activite.index') }}";
            });

        });
    </script>
@endpush

