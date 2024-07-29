@extends('layouts.base2')
@section('title', 'Interface de gestion de droit')
@section('content')
    @section('titlePage')  <h1 class="m-0">Création d'un compte </h1> @stop
    <div class="container">
        <!-- include('layouts.flash-message') -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @adminbarreau
                            @include('droits.profils.index')
                        @endadminbarreau
                        <!-- @avocat
                            @include('droits.profils.index')
                        @endavocat
                        @user
                            @include('droits.profils.index')
                        @enduser -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop


