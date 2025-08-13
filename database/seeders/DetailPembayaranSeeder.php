<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailPembayaran;


class DetailPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            [
                'pembayaran_id'=>'1',
                'bulan_bayar' => 2022-01-01
            ],
            [
                'pembayaran_id'=>'2',
                'bulan_bayar'=> 2022-02-01
            ],
            [
                'pembayaran_id'=>'2',
                'bulan_bayar'=> 2022-03-01
            ],
        ];

        foreach($details as $detail){
            DetailPembayaran::create($detail);
        }
    }
}
