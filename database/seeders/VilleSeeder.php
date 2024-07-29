<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ville;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ville::Create(['nom_ville' => "Abengourou"]);
        Ville::Create(['nom_ville' => "Bondoukou"]);
        Ville::Create(['nom_ville' => "Bouna"]);
        Ville::Create(['nom_ville' => "Abidjan Plateau"]);
        Ville::Create(['nom_ville' => "Aboisso"]);
        Ville::Create(['nom_ville' => "Adzopé"]);
        Ville::Create(['nom_ville' => "Agboville"]);
        Ville::Create(['nom_ville' => "Grand Bassam"]);
        Ville::Create(['nom_ville' => "Abidjan Yopougon"]);
        Ville::Create(['nom_ville' => "Dabou"]);
        Ville::Create(['nom_ville' => "Tiassalé"]);
        Ville::Create(['nom_ville' => "Divo"]);
        Ville::Create(['nom_ville' => "Lakota"]);
        Ville::Create(['nom_ville' => "T Commerce"]);
        Ville::Create(['nom_ville' => "Bouaké"]);
        Ville::Create(['nom_ville' => "Bongouanou"]);
        Ville::Create(['nom_ville' => "Dimbokro"]);
        Ville::Create(['nom_ville' => "Katiola"]);
        Ville::Create(['nom_ville' => "M'Bayakro"]);
        Ville::Create(['nom_ville' => "Toumodi"]);
        Ville::Create(['nom_ville' => "Korhogo"]);
        Ville::Create(['nom_ville' => "Boundiali"]);
        Ville::Create(['nom_ville' => "Odionné"]);
        Ville::Create(['nom_ville' => "Daloa"]);
        Ville::Create(['nom_ville' => "Issia"]);
        Ville::Create(['nom_ville' => "Séguéla"]);
        Ville::Create(['nom_ville' => "Soubré"]);
        Ville::Create(['nom_ville' => "Bouaffé"]);
        Ville::Create(['nom_ville' => "Sinfra"]);
        Ville::Create(['nom_ville' => "Gagnoa"]);
        Ville::Create(['nom_ville' => "Oumé"]);
        Ville::Create(['nom_ville' => "Man"]);
        Ville::Create(['nom_ville' => "Danané"]);
        Ville::Create(['nom_ville' => "Guiglo"]);
        Ville::Create(['nom_ville' => "Touba"]);
        Ville::Create(['nom_ville' => "San Pédro"]);
        Ville::Create(['nom_ville' => "Sassandra"]);
        Ville::Create(['nom_ville' => "Tabou"]);
    }
}
