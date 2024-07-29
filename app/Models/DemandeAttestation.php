<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAttestation extends Model
{
    use HasFactory;
    protected $table = "demande_attestations";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statut()
    {
        return $this->belongsTo(EtatQualificatif::class);
    }

    public function attestations()
    {
        return $this->hasMany(Attestation::class);
    }
}
