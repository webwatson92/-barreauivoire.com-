<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\{User,HistorisationUser};
use Auth;
use Str;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    // use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'prenom',
        'name',
        'email',
        'sexe',
        'telephone',
        'lieu_structure',
        'password',
        // 'profil_id ',
        'login',
        'two_factor_code', // [tl! add]
        'two_factor_expires_at', // [tl! add]
    ];
    
    protected $guarded = [];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function roles(){
    //     return $this->belongsToMany(Role::class);
    // }

    // public function profils()
    // {
    //     return $this->belongsToMany(Profil::class, 'profil_user', 'profil_id', 'user_id');
    // }

    public function historisation_user()
    {
        return $this->belongsTo(HistorisationUser::class);
    }

    protected static function booted(){
        static::creating(function($user){
            $user->id = (string) Str::uuid();
        });
    }

    public function generateCode()
    {
        $code = rand(1000, 9999);
        UserCode::updateOrCreate(
            [ 'user_id' => auth()->user()->id ],
            [ 'code' => $code ]
        );
    
        try {
  
            $details = [
                'title' => 'Mail from Edunov',
                'code' => $code
            ];
             
            Mail::to(auth()->user()->email)->send(new SendCodeMail($details));
    
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }

    public function generateTwoFactorCode(){
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }
    
    public function resetTwoFactorCode(){
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    // Relation pour les documents envoyés par l'utilisateur
    // public function documentsEnvoyes()
    // {
    //     return $this->hasMany(Document::class, 'user_id');
    // }
    public function documentsEnvoyes()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function documentsRecus()
    {
        return $this->belongsToMany(Document::class, 'document_user', 'user_id_2', 'document_id')
                    ->withTimestamps(); // Si vous souhaitez conserver les timestamps sur la relation
    }

    public function conclusionsEnvoyes()
    {
        return $this->hasMany(Conclusion::class, 'user_id');
    }

    public function conclusionsRecus()
    {
        return $this->belongsToMany(Conclusion::class, 'conclusion_user', 'user_id_2', 'conclusion_id')
                    ->withTimestamps(); // Si vous souhaitez conserver les timestamps sur la relation
    }

    //User envoi plusieurs demande
    public function demandesAttestations()
    {
        return $this->hasMany(DemandeAttestation::class);
    }

    //avocat peux enregistrer plusieurs tribunaux
    public function tribunaux()
    {
        return $this->hasMany(Tribunal::class);
    }

    // public function documents()
    // {
    //     return $this->belongsToMany(Document::class, 'document_user')->withTimestamps();
    // }

    public static function historiserCreationOrModificationCompte($request){
        $historique = new HistorisationUser(); 
        $historique->name = $request->name;
        $historique->prenom = $request->prenom;
        $historique->action = "updated";
        $historique->user_id = Auth::user()->id;
        $historique->save();
    }

    public static function historiserValidationOuRejeterDemandeAttestation($statut){
        $historique = new HistorisationUser(); 
        $userConnecter = User::where('id', Auth::user()->id)->first();
        $historique->name = $userConnecter->name;
        $historique->prenom = $userConnecter->prenom;
        $historique->action = $statut == 2 ? "Valider demande attestation" : "Rejeter demande attestation";
        $historique->user_id = Auth::user()->id;
        $historique->save();
    }

    public static function historiserUneAction($action){
        $historique = new HistorisationUser(); 
        $userConnecter = User::where('id', Auth::user()->id)->first();
        $historique->name = $userConnecter->name;
        $historique->prenom = $userConnecter->prenom;
        $historique->action = $action;
        $historique->user_id = Auth::user()->id;
        $historique->save();
    }


}
