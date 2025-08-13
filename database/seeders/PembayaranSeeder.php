<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembayarans = [
            [
                'user_id'=>'1',
                'pegawai_id' => '2',
                'status'=>'1',
                'verifikasi_bendahara'=>true,
                'biaya'=>'50000',
                'jumlah_bulan'=>'1',
            ],
            [
                'user_id'=>'1',
                'pegawai_id' => '2',
                'status'=>true,
                'verifikasi_bendahara'=>false,
                'biaya'=>'100000',
                'jumlah_bulan'=>'2',
            ]
        ];

        foreach($pembayarans as $pembayaran){
            Pembayaran::create($pembayaran);
        }
    }
}
