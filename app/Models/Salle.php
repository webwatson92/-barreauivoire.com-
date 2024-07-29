<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'nom',
        'description',
        'capacite',
        'lieu',
        'disponiblite',
        'cout',
        'etat_qualificatif_id',
        'user_id',
    ];
    
    protected $table = "salles";
    
}
