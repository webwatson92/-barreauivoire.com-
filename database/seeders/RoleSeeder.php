<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::Create([
            'name' => "superadmin",
            'guard_name' => ''
        ]);
        Role::Create([
            'name' => "admin",
            'guard_name' => ''
        ]);
        Role::Create([
            'name' => "barreau",
            'guard_name' => ''
        ]);
        Role::Create([
            'name' => "avocat",
            'guard_name' => ''
        ]);
        Role::Create([
            'name' => "user",
            'guard_name' => ''
        ]);
        
    }
}
