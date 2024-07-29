<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use App\Notifications\TwoFactorCode;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        
        if (!is_null($this->form) && isset($this->form->email)) {
            $user = User::where('email', $this->form->email)->first();
            
            if (!is_null($user)) {
                if (Auth::attempt(['email' => $this->form->email, 'password' => $this->form->password], $this->form->remember)) {
                    Session::regenerate();
                    if ($user->password_change_at === null && $user->pass === "monbarreau") {
                        $this->generateAndSendTwoFactorCode($user);
                        $this->redirectIntended(default: route('vue.changer.motdepasse', absolute: false), navigate: true);
                    } else {
                        $user = User::where('email', $this->form->email)->first();
                        $this->generateAndSendTwoFactorCode($user);
                        $this->redirectIntended(default: route('verify.index', absolute: false), navigate: true);
                    }
                } else {
                    $this->addError('form.password', 'Invalid credentials.');
                }
            } else {
                $this->addError('form.email', 'User not found.');
            }
        } else {
            $this->addError('form.email', 'Email field is required.');
        }
    }

    protected function generateAndSendTwoFactorCode($user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }
};
?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
