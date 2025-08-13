<?php

namespace Database\Seeders;

use App\Models\Rekanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rekanans = [
            [
                'nama' => 'Cipta Ungasan Bersih',
                'email' => 'cub@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'Ungasan Hijau Mandiri',
                'email' => 'uhm@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'Active Berseri',
                'email' => 'ab@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'Mertha Sari',
                'email' => 'ms@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'I Ketut Jaya Kusuma',
                'email' => 'ktk@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'Perumahan Bukit Ungasan Permai',
                'email' => 'bup@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
            [
                'nama' => 'Intan Permata Residence',
                'email' => 'ipr@gmail.com',
                'telp' => '08767876678',
                'alamat' => 'Jalan Raya Ungasan'
            ],
        ];

        foreach($rekanans as $rekanan){
            Rekanan::create($rekanan);
        }
    }
}
