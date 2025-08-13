<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengambilan;

class PengambilanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengambilans = [
            [
                'status' => '1',
                'gambar' => 'image.jpg',
                'pegawai_id'=> '2',
                'user_id'=>'1',
            ],
            [
                'status' => '2',
                'gambar' => 'image.jpg',
                'alasan'=> 'tidak rapih',
                'pegawai_id'=> '2',
                'user_id'=>'1',
            ],
            [
                'status' => '0',
                'gambar' => 'image.jpg',
                'pegawai_id'=> '2',
                'user_id'=>'1',
            ]
        ];

        foreach($pengambilans as $pengambilan){
            Pengambilan::create($pengambilan);
        }
    }
}
