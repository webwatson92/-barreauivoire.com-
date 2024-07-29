<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Statut;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Statut::Create([
            'titre' => "Normal"
        ]);
        Statut::Create([
            'titre' => "Moyen"
        ]);
        Statut::Create([
            'titre' => "Urgent"
        ]);
    }
}
