<?php

namespace Database\Seeders;

use App\Models\KodeDistribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodeDistribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $distribusis = [
            [
                'objek' => 'Rumah Tangga 1-5 Org',
                'kode' => 'A.1',
                'kategori' => '1',
                'jumlah' => '30000'
            ],
            [
                'objek' => 'Toko Kecil',
                'kode' => 'B.6',
                'kategori' => '2',
                'jumlah' => '50000'
            ]
            
        ];

        foreach($distribusis as $distribusi){
            KodeDistribusi::create($distribusi);
        }
    }
}
