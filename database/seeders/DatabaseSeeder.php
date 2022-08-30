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
use Illuminate\Support\Str;

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
            'slug' => Str::slug('rsud kepahiang', '-'),
            'opd_name' => 'rsud kepahiang',
            'opd_address' => 'Jln. Lintas Kepahiang - Bengkulu',
            'opd_longitude' => '102.562136',
            'opd_latitude' => '-3.6632719',
            'distance' => 1000
        ]);

        Opd::create([
            'slug' => Str::slug('rsud kepahiang lama', '-'),
            'opd_name' => 'rsud kepahiang lama',
            'opd_address' => 'Jln. Pasar kepahiang',
            'opd_longitude' => '102.574515',
            'opd_latitude' => '-3.6441869',
            'distance' => 1000
        ]);

        //DEFAULT USER
        User::create([
            'name' => 'super admin',
            'nip' => '000000000000000000',
            'email' => 'admin@absensi.com',
            'password' => Hash::make('superadmin'),
            'role_id' => 1,
        ]);

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
            'role_id' => 6,
        ]);

        User::create([
            'name' => 'user 2',
            'nip' => '111111111111111117',
            'email' => 'user2@absensi.com',
            'password' => Hash::make('user'),
            'role_id' => 6,
        ]);

        //user kominfo
        $users = [
            [
                "name" => "DICKY ISWANDI"	,
                "nip"=>	"198009042006041007",
                "email"=>	"dickyiswandi@kepahiangkab.go.id",
                "password" =>	198009042006041007,
            ],
            [
                "name" =>	"DEWI FITRIA",
                "nip"=>	"198307122006042026",
                "email"=>	"dewifitria@kepahiangkab.go.id",
                "password" =>	198307122006042026

            ],
            [
                "name" =>	"DONI IRAWAN",
                "nip"=>	"198108142008041002",
                "email"=>	"doniirawan@kepahiangkab.go.id",
                "password" =>	198108142008041002

            ],
            [
                "name" =>	"EKA MISTRIANI"	,
                	"nip"=>	"197905272006042008",
                	"email"=>	"ekamistriani@kepahiangkab.go.id",
                	"password" =>	197905272006042008

            ],
            [
                "name" =>	"EKA YUNITA"	,
                	"nip"=>	"198006072005022004",
                	"email"=>	"ekayunita@kepahiangkab.go.id",
                	"password" =>	198006072005022004

            ],
            [
                "name" =>	"FAUZAN AKBAR"	,
                	"nip"=>	"197705012010011016",
                	"email"=>	"fauzanakbar@kepahiangkab.go.id",
                	"password" =>	197705012010011016
            ],
            [
                "name" =>	"FIRLI EKONANTO"	,
                	"nip"=>	"198006172009041001",
                	"email"=>	"firliekonanto@kepahiangkab.go.id",
                	"password" =>	198006172009041001

            ],
            [
                "name" =>	"GROTA NUR HIDAYATULLAH"	,
                	"nip"=>	"197712172002121004",
                	"email"=>	"grota.n.h@kepahiangkab.go.id",
                	"password" =>	197712172002121004

            ],
            [
                "name" =>	"HELMAN",
                	"nip"=>	"197206212006041001",
                	"email"=>	"helman@kepahiangkab.go.id",
                	"password" =>	197206212006041001

            ],
            [
                "name" =>	"HERU FEBISTIAN"	,
                	"nip"=>	"199311032019031006",
                	"email"=>	"herufebistian@kepahiangkab.go.id",
                	"password" =>	199311032019031006

            ],
            [
                "name" =>	"HERVENSI"	,
                	"nip"=>	"198206052009041003",
                	"email"=>	"hervensi@kepahiangkab.go.id",
                	"password" =>	198206052009041003

            ],
            [
                "name" =>	"JOKO PURNOMO"	,
                	"nip"=>	"198501042011011009",
                	"email"=>	"jokopurnomo85@kepahiangkab.go.id",
                	"password" =>	198501042011011009

            ],
            [
                "name" =>	"JULIAN APFRIANSAH"	,
                	"nip"=>	"198507142006041002",
                	"email"=>	"julianapfriansah@kepahiangkab.go.id",
                	"password" =>	198507142006041002

            ],
            [
                "name" =>	"KATIN LASMINI"	,
                	"nip"=>	"198309182008042001",
                	"email"=>	"katinlasmini@kepahiangkab.go.id",
                	"password" =>	198309182008042001

            ],
            [
                "name" =>	"M YAMIN D"	,
                	"nip"=>	"197210061998031006",
                	"email"=>	"myamind@kepahiangkab.go.id",
                	"password" =>	197210061998031006

            ],
            [
                "name" =>	"NOVA ATIKASARI"	,
                	"nip"=>	"198711252006042002",
                	"email"=>	"novaatikasari@kepahiangkab.go.id",
                	"password" =>	198711252006042002

            ],
            [
                "name" =>	"RIKI HERMANSYAH"	,
                	"nip"=>	"199403262019031009",
                	"email"=>	"rikihermansyah31@kepahiangkab.go.id",
                	"password" =>	199403262019031009

            ],
            [
                "name" =>	"WINARTI"	,
                	"nip"=>	"198401132010012019",
                	"email"=>	"winarti@kepahiangkab.go.id",
                	"password" =>	198401132010012019

            ],
            [
                "name" =>	"YOBA PRAJA"	,
                	"nip"=>	"198708232015051001",
                	"email"=>	"yobapraja@kepahiangkab.go.id",
                	"password" =>	198708232015051001

            ],
            [
                "name" =>	"YOSEP HARYANTO"	,
                	"nip"=>	"198109212009041001",
                	"email"=>	"yosepharyanto@kepahiangkab.go.id",
                	"password" =>	198109212009041001

            ],
            [
                "name" =>	"YUDHI PAHNOPI"	,
                	"nip"=>	"197906232011011002",
                	"email"=>	"yudhipahnopi@kepahiangkab.go.id",
                	"password" =>	197906232011011002

            ],
            [
                "name" =>	"NURIMANI"	,
                	"nip"=>	"196901281998032001",
                	"email"=>	"nurimani@kepahiangkab.go.id",
                	"password" =>	196901281998032001

            ],
            [
                "name" =>	"HERMAINI"	,
                	"nip"=>	"198204202006042015",
                	"email"=>	"hermaini@kepahiangkab.go.id",
                	"password" =>	198204202006042015

            ],
            [
                "name" =>	"RIDUAN M"	,
                	"nip"=>	"198209122006041007",
                	"email"=>	"riduanm@kepahiangkab.go.id",
                	"password" =>	198209122006041007

            ],
            [
                "name" =>	"FAJRINA HANIFAH"	,
                	"nip"=>	"19960503 202203201"	,
                	"email"=>	"fajrinahanifah@kepahiangkab.go.id",
                	"password" =>	199605032022032015

            ],
            [
                "name" =>	"MOHAMMAD SOFIUDIN"	,
                	"nip"=>	"199210152022031001",
                	"email"=>	"mohammadsofiudin@kepahiangkab.go.id",
                	"password" =>	199210152022031001

            ],
            [
                "name" =>	"NOVA SURYA ANGGRAINI"	,
                	"nip"=>	"199411212022032023",
                	"email"=>	"novasuryaanggraini@kepahiangkab.go.id",
                	"password" =>	199411212022032023

            ],
            [
                "name" =>	"ELFIAN SAPUTRA"	,
                	"nip"=>	"199401092022031013",
                	"email"=>	"elfiansaputra@kepahiangkab.go.id",
                	"password" =>	199401092022031013

            ],
            [
                "name" =>	"FATIMATUZZUHRO",
                	"nip"=>	"199609092022032019",
                	"email"=>	"fatimatuzzuhro@kepahiangkab.go.id",
                	"password" =>	199609092022032019

            ],
            [
                "name" =>	"MUHAMAD IQBAL AGRYANUS UTAMA"	,
                	"nip"=>	"199708062022031005",
                	"email"=>	"miqbalagryanusutama@kepahiangkab.go.id",
                	"password" =>	199708062022031005

            ],
            [
                "name" =>	"ARIAN PERDOMUAN"	,
                	"nip"=>	"199212232022031008",
                	"email"=>	"arianperdomuan@kepahiangkab.go.id",
                	"password" =>	199212232022031008
            ]

        ];

        foreach($users as $user) {
            User::create([
                'name' => $user['name'],
                'nip' => $user['nip'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role_id' => 6
            ]);
        }


        //USER DETAIL
        UserDetail::create([
            'nik' => '1704082112970003',
            'user_id' => 3,
            'pangkat' => 'IIIA',
            'jabatan' => 'staff',
        ]);

        UserDetail::create([
            'nik' => '1704082112970004',
            'user_id' => 4,
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
        UserOnOpd::create([
            'valid' => 0,
            'is_super' => 1,
            'user_id' => 2,
            'opd_id' => 1
        ]);

    }
}
