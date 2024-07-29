@extends('layouts.base2')
@section('title', 'Interface de gestion de contact')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
@endpush
@section('content')
    @section('titlePage')  <h1 class="m-0">Listes de mon répertoire</h1> @stop
    <div class="container" style="padding-bottom: 2em; padding-top: 1em">
        @include('layouts.flash-message')
        @livewire('back.contact.contact-list-favoris')
    </div>
@stop
@section('footer')
    <script>
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "ci", // Pays par défaut
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });

        iti.promise.then(function() {
            var countryCodeInput = document.querySelector("#country-code");
            input.addEventListener("countrychange", function() {
                countryCodeInput.value = iti.getSelectedCountryData().dialCode;
            });
        });
    </script>

@stop