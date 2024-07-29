<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <div class="left-side">
                <div class="overlay">
                    <div class="logo">LE LOGO</div>
                    <div class="welcome-message">
                        <p>BIENVENUE SUR NOTRE</p>
                        <p>PLATEFORME DE GESTION</p>
                        <p>Mon barreau et moi</p>
                        <p>RCI</p>
                    </div>
                </div>
            </div>
            <div class="right-side">
                <div class="login-box">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
