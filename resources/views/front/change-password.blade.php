<x-app-layout>
    <div class="container" style="padding-top: 5em">
        <div>
            <h1 style="font-size:3em"><b>Changer votre mot de passe</b></h1>
            <div class="mb-4 text-md text-gray-600">
                <p>
                   
                </p>    
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            @if(session()->has('message'))
                <p class="alert alert-info">
                    {{ session()->get('message') }}
                </p>
            @endif
            <form method="POST" action="{{ route('valider.changer.motdepasse') }}">
                
                @csrf
                <!-- Email Address -->
                
                <input type="hidden" name="name" value="{{ $user->name }}">
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Soumettre') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
