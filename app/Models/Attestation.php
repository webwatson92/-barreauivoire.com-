<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    use HasFactory;
    protected $table = "attestations";
    protected $guarded = [];

    public function demandeAttestation()
    {
        return $this->belongsTo(DemandeAttestation::class);
    }
}
