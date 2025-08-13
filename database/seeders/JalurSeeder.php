<?php

namespace Database\Seeders;

use App\Models\Jalur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jalurs = [
            [
                'nama' => 'A',
            ],
            [
                'nama' => 'B',
            ]
        ];

        foreach($jalurs as $jalur){
            Jalur::create($jalur);
        }
    }
}
