<?php

namespace Database\Seeders;

use App\Models\JenisPendapatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPendapatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_pendapatans = [
            [
                'nama' => 'Pendapatan Fee',
            ],
            [
                'nama' => 'Pendapatan Panggilan',
            ],
            [
                'nama' => 'List Cash Back',
            ]
        ];

        foreach($jenis_pendapatans as $jenis_pendapatan){
            JenisPendapatan::create($jenis_pendapatan);
        }
    }
}
