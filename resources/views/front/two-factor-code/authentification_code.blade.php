

<x-app-layout>
    <div class="container" style="padding-top: 5em">
        <h1 style="font-size:3em"><b>Authentification à deux facteurs</b></h1>
        <div class="mb-4 text-md text-gray-600">
            <p>
                Vous avez reçu un mail avec vos information de connexion 
                y compris votre code d'authentication. Si vous n'avez pas reçu 
                <a href="{{ route('verify.resend') }}"><b>Cliquer ici</b></a>
            </p>    
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if(session()->has('message'))
            <p class="alert alert-info">
                {{ session()->get('message') }}
            </p>
        @endif

        <form method="POST" action="{{ route('verify.store') }}">
            {{ csrf_field() }}
            <div>
                <x-input-label for="email" :value="__('Authentification à deux facteurs code')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="two_factor_code" required autofocus />
                <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Authentifiez-vous') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
