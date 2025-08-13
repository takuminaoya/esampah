<?php

namespace Database\Seeders;

use App\Models\DetailJalur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailJalurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_jalurs = [
            [
                'jalur_id' => '1',
                'banjar_id' => '3'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '10'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '9'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '7'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '6'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '8'
            ],
            [
                'jalur_id' => '1',
                'banjar_id' => '11'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '14'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '1'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '4'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '5'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '13'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '12'
            ],
            [
                'jalur_id' => '2',
                'banjar_id' => '2'
            ],
        ];

        foreach($detail_jalurs as $detail_jalur){
            DetailJalur::create($detail_jalur);
        }
    }
}
