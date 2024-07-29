<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Profil extends Model
{
    use HasFactory;
    protected $table = "profils";

    protected $primaryKey = 'id';
    protected $fillable =  ['libelle', 'statut', 'route', 'description', 
            'prenom', 'lieu_structure', 'login', 'date_naissance', 'date_prestation', 
            'expertise', 'etat_qualificatid_id', 'user_id'];
    // protected $guarded = ['id'];

    // protected static function booted(){
    //     static::creating(function($user){
    //         $user->id = (string) Str::uuid();
    //     });
    // }

    
}
