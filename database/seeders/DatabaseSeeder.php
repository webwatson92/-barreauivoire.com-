<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // $this->call([EventSeeder::class,]);
        $this->call([EtatQualificatifSeeder::class,]);
        $this->call([StatusSeeder::class,]);
        $this->call([RoleSeeder::class,]);
        $this->call([VilleSeeder::class,]);
    }
}
