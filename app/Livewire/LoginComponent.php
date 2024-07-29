<?php

namespace App\Livewire;


use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use App\Notifications\TwoFactorCode;

// use Livewire\Component;

class LoginComponent extends Component
{
    public function render()
    {
        return view('livewire.login-component');
    }
}
