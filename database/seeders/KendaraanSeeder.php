<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kendaraans = [
            [
                'plat' => 'DK 8467 MF',
                'rekanan_id' => '1'
            ],
            [
                'plat' => 'DK 8530 QC',
                'rekanan_id' => '3'
            ],
            [
                'plat' => 'DK 8771 QO',
                'rekanan_id' => '3'
            ],
            [
                'plat' => 'DK 8513 OM',
                'rekanan_id' => '4'
            ]
        ];

        foreach($kendaraans as $kendaraan){
            Kendaraan::create($kendaraan);
        }
    }
}
