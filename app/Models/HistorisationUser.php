<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorisationUser extends Model
{
    use HasFactory;
    protected $table ="historisation_users";

    protected $fillable = [
        'name',
        'prenom',
        'action',
        'user_id'
    ];
    
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
