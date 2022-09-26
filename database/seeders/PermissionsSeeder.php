<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'role_id' => 1,
            'can' => 'dashboard,create-user,report'
        ]);

        Permission::create([
            'role_id' => 2,
            'can' => 'admin,create-user,get-user,get-users'
        ]);
    }
}
