<?php

// use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use App\Notifications\TwoFactorCode;

new #[Layout('layouts.login_l')] class extends Component
{
    
};
?>
<div class="row h-100" style="margin: 0; overflow: hidden;">
    <div class="col-sm-8 d-flex align-items-center justify-content-center" style="background-image: url('assets/img/background.PNG'); background-size: cover; background-position: center;">
        <p style="padding-top: 35em;padding-bottom: 6em; text-align:center;color: #fff;font-weight:bold; border-style:none;">
            BIENVENUE SUR NOTRE PLATEFORME DE GESTION 
            {{ config('app.name') }} <br><br>
            RCI (République de Côte d'Ivoire)
        </p>
    </div>
    <div class="col-sm-4 d-flex align-items-center justify-content-center" style="background-color: #272d69;">
        <div class="container">
            <div class="row">
                <h3 style="color: #fff; text-align: center;">CONNECTEZ-VOUS A VOTRE ESPACE {{ config('app.name') }}</h3>
            </div>
            <br><br>
            <p style="color:#fff">
                @include('layouts.flash-message')
            </p>
            <form method="post" action="{{ route('logged') }}">
                @csrf
                <div class="form-group">
                    <label for="name" style="color:#fff">Email</label>
                    <input type="text" class="form-control" name="identifiant" placeholder="Email">
                </div>
                <br>
                <div class="form-group">
                    <label for="password" style="color:#fff">Mot de passe</label>
                    <input type="password" class="form-control" name="password" placeholder="****************">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg form-control">Se Connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>