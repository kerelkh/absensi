<?php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserOnOpd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //ROLES SEED
        Role::create([
            'role_name' => 'super admin'
        ]);

        Role::create([
            'role_name' => 'admin kepegawaian'
        ]);

        Role::create([
            'role_name' => 'admin dinas'
        ]);

        Role::create([
            'role_name' => 'admin keuangan',
        ]);

        Role::create([
            'role_name' => 'supervisor'
        ]);

        Role::create([
            'role_name' => 'user'
        ]);

        //OPD SEED
        Opd::create([
            'opd_name' => 'rsud kepahiang',
            'opd_address' => 'Jln. Lintas Kepahiang - Bengkulu',
            'opd_longitude' => '102.562136',
            'opd_latitude' => '-3.6632719',
        ]);

        Opd::create([
            'opd_name' => 'rsud kepahiang lama',
            'opd_address' => 'Jln. Pasar kepahiang',
            'opd_longitude' => '102.574515',
            'opd_latitude' => '-3.6441869',
        ]);

        //DEFAULT USER
        User::create([
            'name' => 'admin kepegawaian',
            'nip' => '111111111111111111',
            'email' => 'adminkepegawaian@absensi.com',
            'password' => Hash::make('admin'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'admin dinas',
            'nip' => '111111111111111112',
            'email' => 'admindinas@absensi.com',
            'password' => Hash::make('admin'),
            'role_id' => 3,
        ]);

        User::create([
            'name' => 'user',
            'nip' => '111111111111111116',
            'email' => 'user@absensi.com',
            'password' => Hash::make('user'),
            'role_id' => 5,
        ]);

        User::create([
            'name' => 'user 2',
            'nip' => '111111111111111117',
            'email' => 'user2@absensi.com',
            'password' => Hash::make('user'),
            'role_id' => 5,
        ]);


        //USER DETAIL
        UserDetail::create([
            'nik' => '1704082112970003',
            'active_status' => 0,
            'user_id' => 3,
            'pangkat' => 'IIIA',
            'jabatan' => 'staff',
        ]);

        //USER ON OPD
        UserOnOpd::create([
            'valid' => 1,
            'is_super' => 0,
            'user_id' => 3,
            'opd_id' => 1
        ]);

    }
}
