<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtatQualificatif extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "etat_qualificatifs";

    public function demandesAttestations()
    {
        return $this->hasMany(DemandeAttestation::class);
    }
    
}
