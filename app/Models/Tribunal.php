<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tribunal extends Model
{
    use HasFactory;

    protected $table = "tribunals";
    protected $guarded = [];
    protected $fillable = ['nom_tribunal', 'ville_id'];


    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function audiences()
    {
        return $this->hasMany(Audience::class, 'tribunal_id');
    }
}
