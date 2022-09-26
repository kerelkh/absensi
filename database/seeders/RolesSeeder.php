<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name' => 'superadmin',
            'default_route' => 'dashboard'
        ]);

        Role::create([
            'role_name' => 'admin',
            'default_route' => 'admin'
        ]);

        Role::create([
            'role_name' => 'operator',
            'default_route' => 'dashboard'
        ]);

        Role::create([
            'role_name' => 'duty',
            'default_route' => 'dashboard'
        ]);

        Role::create([
            'role_name' => 'supervisor',
            'default_route' => 'dashboard'
        ]);

        Role::create([
            'role_name' => 'user',
            'default_route' => 'dashboard'
        ]);
    }
}
