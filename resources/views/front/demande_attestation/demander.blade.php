@extends('layouts.base2')
@section('title', "Interface de demande d'attestation")
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h3 class="m-0">Cliquer sur le bouton pour faire votre demande</h3> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')

        <div class="row col-sm-6">
            @livewire('back.demandeattestation.demande')
        </div>

    </div>
@stop
@section('footer')
  
@stop