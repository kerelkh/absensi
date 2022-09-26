<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Juru Muda / Ia',
            'Juru Muda Tingkat I / Ib',
            'Juru / Ic',
            'Juru Tingkat I / Id',
            'Pengatur Muda / IIa',
            'Pengatur Muda Tingkat I / IIb',
            'Pengatur / IIc',
            'Pengatur Tingkat I / IId',
            'Penata Muda / IIIa',
            'Penata Muda Tingkat I / IIIb',
            'Penata / IIIc',
            'Penata Tingkat I / IIId',
            'Pembina / IVa',
            'Pembina Tingkat I / IVb',
            'Pembina Muda / IVc',
            'Pembina Madya / IVd',
            'Pembina Utama / IVe',
        ];

        foreach($data as $dt) {
            Rank::create([
                'rank_name' => $dt,
            ]);
        }
    }
}
