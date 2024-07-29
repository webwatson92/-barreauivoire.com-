<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EtatQualificatif;

class EtatQualificatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EtatQualificatif::Create([
            'libelle' => "demande de modification"
        ]);
        EtatQualificatif::Create([
            'libelle' => "valider"
        ]);
        EtatQualificatif::Create([
            'libelle' => "en attente de validation"
        ]);
        EtatQualificatif::Create([
            'libelle' => "rejeter"
        ]);
        EtatQualificatif::Create([
            'libelle' => "supprimer"
        ]);
        EtatQualificatif::Create([
            'libelle' => "traiter"
        ]);
        EtatQualificatif::Create([
            'libelle' => "libre"
        ]);
        EtatQualificatif::Create([
            'libelle' => "occuper"
        ]);
    }
}
