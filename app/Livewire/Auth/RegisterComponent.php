<?php

namespace App\Livewire\Auth;

use App\Models\{User, Profil};
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
// use Livewire\Component;

class RegisterComponent extends Component
{
    public string $code = '';
    public string $name = '';
    public string $prenom = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $profil;

    public function mount(){
        $this->selectedProfil = '';
    }
    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'code' => ['required', 'string'],
            'name' => ['required', 'string', 'max:10'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'profil' => ['required'],
        ]);

        $validated['login'] = $validated['name'].'.'.$validated['prenom'];
        $validated['password'] = Hash::make($validated['password']);

        $profilId = $validated['selectedProfil'];

        $user->profils()->attach($profilId);

        event(new Registered($user = User::create($validated)));

        // $userId = $user->id;
        // $profilId = $validated['profil'];
        // dump($userId);
        // dump($profilId);
        // $profilConnexion = new ProfilUser();
        // $profilConnexion->profil_id = $profilId;
        // $profilConnexion->user_id = $userId;
        // $profilConnexion->save();
        // Auth::login($user);//Authentifier l'utilisateur
        $this->redirect(route('login', absolute: false), navigate: true);
    }

    public function render()
    {
        $profils = Profil::all()->pluck('libelle', 'id');
        return view('livewire.pages.auth.register-component', compact('profils'))->layout('layouts.guest');
    }
}
