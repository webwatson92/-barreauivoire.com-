<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;
    protected $table = "audiences";
    protected $fillable = ['audience', 'ville_id', 'tribunal_id',  'date_conseil', 'heure_debut', 'heure_fin'];
    protected $guarded = [];

    public function tribunal(){
        return $this->belongsTo(Tribunal::class);
    }

    public function ville(){
        return $this->belongsTo(Ville::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
