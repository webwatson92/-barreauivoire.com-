<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $table = "villes";
    protected $fillable = ['nom_ville'];

    public function audiences(){
        return $this->hasMany(Audience::class, 'ville_id');
    }

    public function tribunaux(){
        return $this->hasMany(Tribunal::class);
    }

}
