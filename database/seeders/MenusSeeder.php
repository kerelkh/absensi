<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'name' => 'dashboard',
            'url' => 'dashboard',
            'icon' => '<i class="fa-solid fa-chart-line w-3 h-3 mr-3" role="img"></i>',
            'menu_group' => 1,
            'flag' => 1,
            'flag_menu' => 1,
        ]);

        Menu::create([
            'name' => 'masters',
            'url' => 'masters',
            'icon' => '<i class="fa-solid fa-lock w-3 h-3 mr-3" role="img"></i>',
            'menu_group' => 1,
            'flag' => 1,
            'flag_menu' => 1,
        ]);

        Menu::create([
            'name' => 'report',
            'url' => 'report',
            'icon' => '<i class="fa-solid fa-chart-line w-3 h-3 mr-3" role="img"></i>',
            'menu_group' => 1,
            'flag' => 0,
            'flag_menu' => 1,
        ]);

        Menu::create([
            'name' => 'create-user',
            'url' => 'create-user',
            'flag' => 1,
            'flag_menu' => 0,
        ]);

        Menu::create([
            'name' => 'users',
            'url' => 'users',
            'icon' => '<i class="fa-solid fa-user w-3 h-3 mr-3" role="img"></i>',
            'menu_group' => 2,
            'flag' => 1,
            'flag_menu' => 1,
        ]);

        Menu::create([
            'name' => 'admin',
            'url' => 'admin',
            'icon' => '<i class="fa-solid fa-gauge w-3 h-3 mr-3" role="img""></i>',
            'menu_group' => 1,
            'flag' => 1,
            'flag_menu' => 1,
        ]);
    }
}
