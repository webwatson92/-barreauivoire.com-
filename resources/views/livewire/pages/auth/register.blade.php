<?php

use App\Models\User;
use App\Models\Code;
use App\Motifications\CompteCree;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $code = '';
    public string $name = '';
    public string $prenom = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    // public $profil;
    // public ?string $profil_id = null;

    // public function mount()
    // {
    //     $this->profil = Profil::pluck('libelle', 'id');
    // }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'code' => ['required', 'string', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:10'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            // 'profil_id' => ['required'],
        ]);

        $rechercheCodeExistant = Code::whereIn('code_inscription', [$validated['code']])->get();
        
        if(!empty($rechercheCodeExistant) && !is_null($rechercheCodeExistant)){
            $user = User::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'password' => bcrypt('monbarreau'),
                // 'profil_id' => $validated['profil_id'],
                'login' => $validated['name'].'.'.$validated['prenom'],
            ]);
            event(new Registered($user));

            $this->redirect(route('login', absolute: false), navigate: true);
        }else{
            session::flash('message', "Ce code n'exite pas chez le barreau, demandé la création d'un nouveau code.");
            $this->redirect()->back();
        }

        

        // $userId = $user->id;
        // $profil = 1;
        // $profilPivotData =  [];
        // $profilPivot = ['profil_id' => $profil, 'user_id'=> $userId];

        // $pr = $user->profils()->sync($profilPivot);

        // $user->profils()->attach($validated['profil_id']);

       
    }

};

?>

<div>
    <form wire:submit="register">
        <!-- Code -->
        @if(Session::has('message'))
                <div class="allert alert-success" role="alert"><strong>{{Session::get('message')}}</strong></div>
        @endif
        <div>
            <x-input-label for="code" :value="__('Code géréré par le barreau')" />
            <x-text-input wire:model="code" id="code" class="block mt-1 w-full" type="text" name="code" required autofocus autocomplete="code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input wire:model="prenom" id="prenom" class="block mt-1 w-full" type="text" name="prenom" required autofocus autocomplete="prenom" />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <!-- Confirm Password -->
        
        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                <!-- {{ __('Already registered?') }} -->
            </a>

            <x-primary-button class="ms-4">
                {{ __('Créer un compte') }}
            </x-primary-button>
        </div>
    </form>
</div>

