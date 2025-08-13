<?php

namespace Database\Seeders;

use App\Models\Banjar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanjarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banjars = [
            [
                'nama' => 'KANGIN',
            ],
            [
                'nama' => 'KAUH',
            ],
            [
                'nama' => 'KELOD',
            ],
            [
                'nama' => 'SANTHI KARYA',
            ],
            [
                'nama' => 'GIRI DHARMA',
            ],
            [
                'nama' => 'WANA GIRI',
            ],
            [
                'nama' => 'SARI KARYA',
            ],
            [
                'nama' => 'BAKUNG SARI',
            ],
            [
                'nama' => 'KERTHA LESTARI',
            ],
            [
                'nama' => 'WIJAYA KUSUMA',
            ],
            [
                'nama' => 'WERDHI KOSALA',
            ],
            [
                'nama' => 'MEKAR SARI',
            ],
            [
                'nama' => 'ANGAS SARI',
            ],
            [
                'nama' => 'LANGUI',
            ],
        ];

        foreach($banjars as $banjar){
            Banjar::create($banjar);
        }
    }
}
