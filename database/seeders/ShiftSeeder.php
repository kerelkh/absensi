<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'name' => 'shift 1',
            'time_in' => '08:00:00',
            'time_out' => '16:00:00',
        ]);

        Shift::create([
            'name' => 'shift 2',
            'time_in' => '16:00:00',
            'time_out' => '23:00:00',
        ]);

        Shift::create([
            'name' => 'shift 3',
            'time_in' => '00:00:00',
            'time_out' => '08:00:00',
        ]);

    }
}
