<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'superadmin',
            'password' => Hash::make('123456'),
            'role_id' => 1,
            'validation' => 1,
            'created_by' => 'seeder',
        ]);
        User::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role_id' => 2,
            'validation' => 1,
            'created_by' => 'seeder',
        ]);
        User::create([
            'username' => 'operator',
            'password' => Hash::make('123456'),
            'role_id' => 3,
            'validation' => 1,
            'created_by' => 'seeder',
        ]);
        User::create([
            'username' => 'duty',
            'password' => Hash::make('123456'),
            'role_id' => 4,
            'validation' => 1,
            'created_by' => 'seeder',
        ]);
        User::create([
            'username' => 'supervisor',
            'password' => Hash::make('123456'),
            'role_id' => 5,
            'validation' => 1,
            'created_by' => 'seeder',
        ]);
        User::create([
            'username' => 'user',
            'password' => Hash::make('123456'),
            'role_id' => 6,
            'validation' => 0,
            'created_by' => 'seeder',
        ]);

        UserDetail::create([
            'user_id' => '6'
        ]);

    }
}
