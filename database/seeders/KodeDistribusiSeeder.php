<?php

namespace Database\Seeders;

use App\Models\KodeDistribusi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodeDistribusiSeeder extends Seeder
{
    /**
     * Run the database seeds
     *
     * @return void
     */
    public function run()
    {
        $distribusis = [
            [
                'objek' => 'Rumah Tangga 1-5 Org',
                'kode' => 'A1',
                'kategori' => '1',
                'jumlah' => '30000'
            ],
            [
                'objek' => 'Rumah Tangga 6-10 Org',
                'kode' => 'A2',
                'kategori' => '1',
                'jumlah' => '35000'
            ],
            [
                'objek' => 'Rumah Tangga > 10 Org ',
                'kode' => 'A3',
                'kategori' => '1',
                'jumlah' => '40000'
            ],
            [
                'objek' => 'Rumah Mewah / Residence',
                'kode' => 'A4',
                'kategori' => '1',
                'jumlah' => '80000'
            ],
            [
                'objek' => 'Rumah Tinggal /Villa Pribadi ',
                'kode' => 'A5',
                'kategori' => '1',
                'jumlah' => '150000'
            ],
            [
                'objek' => 'Rumah Kost 1 – 5 Kamar',
                'kode' => 'B1',
                'kategori' => '2',
                'jumlah' => '50000'
            ],
            [
                'objek' => 'Rumah Kost 6 – 10 Kamar',
                'kode' => 'B2',
                'kategori' => '2',
                'jumlah' => '80000'
            ],
            [
                'objek' => 'Rumah Kost 11 – 15 Kamar',
                'kode' => 'B3',
                'kategori' => '2',
                'jumlah' => '120000'
            ],
            [
                'objek' => 'Rumah Kost 16 – 25 Kamar',
                'kode' => 'B4',
                'kategori' => '2',
                'jumlah' => '160000'
            ],
            [
                'objek' => 'Rumah Kost > 25 Kamar',
                'kode' => 'B5',
                'kategori' => '2',
                'jumlah' => '200000'
            ],
            [
                'objek' => 'Toko Kecil / Warung Kelontong',
                'kode' => 'B6',
                'kategori' => '2',
                'jumlah' => '50000'
            ],
            [
                'objek' => 'Toko Besar / Mini Market ',
                'kode' => 'B7',
                'kategori' => '2',
                'jumlah' => '100000'
            ],
            [
                'objek' => 'Toko Besar / Super Market',
                'kode' => 'B8',
                'kategori' => '2',
                'jumlah' => '400000'
            ],
            [
                'objek' => 'Rumah Makan Kelas I (kapasitas ≤ 10)',
                'kode' => 'B9',
                'kategori' => '2',
                'jumlah' => '70000'
            ],
            [
                'objek' => 'Rumah Makan Kelas II (kapasitas ≤ 20)',
                'kode' => 'B10',
                'kategori' => '2',
                'jumlah' => '100000'
            ],
            [
                'objek' => 'Rumah Makan Kelas III (kapasitas ≤ 30)',
                'kode' => 'B11',
                'kategori' => '2',
                'jumlah' => '200000'
            ],
            [
                'objek' => 'Restaurant Kelas I (Luas & Standarisasi)',
                'kode' => 'B12',
                'kategori' => '2',
                'jumlah' => '500000'
            ],
            [
                'objek' => 'Restaurant Kelas II (Luas & Standarisasi)',
                'kode' => 'B13',
                'kategori' => '2',
                'jumlah' => '1000000'
            ],
            [
                'objek' => 'Restaurant Kelas III (Luas & Standarisasi)',
                'kode' => 'B14',
                'kategori' => '2',
                'jumlah' => '2000000'
            ],
            [
                'objek' => 'Restaurant Kelas IV (Luas & Standarisasi)',
                'kode' => 'B15',
                'kategori' => '2',
                'jumlah' => '3000000'
            ],
            [
                'objek' => 'Restaurant Kelas V (Luas & Standarisasi)',
                'kode' => 'B16',
                'kategori' => '2',
                'jumlah' => '4000000'
            ],
            [
                'objek' => 'Hotel  / Villa I (Luas & Standarisasi)',
                'kode' => 'B17',
                'kategori' => '2',
                'jumlah' => '600000'
            ],
            [
                'objek' => 'Hotel / Villa II (Luas & Standarisasi)',
                'kode' => 'B18',
                'kategori' => '2',
                'jumlah' => '1000000'
            ],
            [
                'objek' => 'Hotel / Villa III (Luas & Standarisasi)',
                'kode' => 'B19',
                'kategori' => '2',
                'jumlah' => '1500000'
            ],
            [
                'objek' => 'Hotel / Villa IV (Luas & Standarisasi)',
                'kode' => 'B20',
                'kategori' => '2',
                'jumlah' => '2000000'
            ],
            [
                'objek' => 'Hotel / Villa V (Luas & Standarisasi)',
                'kode' => 'B21',
                'kategori' => '2',
                'jumlah' => '3000000'
            ],
            [
                'objek' => 'Hotel / Villa VI (Luas & Standarisasi)',
                'kode' => 'B22',
                'kategori' => '2',
                'jumlah' => '5000000'
            ],
            [
                'objek' => 'Hotel / Villa VII (Luas & Standarisasi)',
                'kode' => 'B23',
                'kategori' => '2',
                'jumlah' => '6000000'
            ],
            [
                'objek' => 'Tempat 2 Bengkel /Furniture/Kantor/DLL',
                'kode' => 'B24',
                'kategori' => '2',
                'jumlah' => '100000'
            ],
            [
                'objek' => 'Pedagang Lesehan /Kaki Lima / Musiman',
                'kode' => 'B25',
                'kategori' => '2',
                'jumlah' => '40000'
            ],
            [
                'objek' => '2 Pasar Kelas I (Luas & Jumlah)',
                'kode' => 'B26',
                'kategori' => '2',
                'jumlah' => '1000000'
            ],
            [
                'objek' => '2 Pasar Kelas II (Luas & Jumlah)',
                'kode' => 'B27',
                'kategori' => '2',
                'jumlah' => '1500000'
            ],
            [
                'objek' => 'Puskesmas / Klinik',
                'kode' => 'B28',
                'kategori' => '2',
                'jumlah' => '150000'
            ],
            [
                'objek' => 'Objek Wisata / 2 lainnya (diatur khusus)',
                'kode' => 'B29',
                'kategori' => '2',
                'jumlah' => '250000'
            ],
            [
                'objek' => 'Sarana Pendidikan Jumlah Siswa ≤ 200 ',
                'kode' => 'C1',
                'kategori' => '2',
                'jumlah' => '100000'
            ],
            [
                'objek' => 'Sarana Pendidikan Jumlah Siswa ≤ 400',
                'kode' => 'C2',
                'kategori' => '2',
                'jumlah' => '150000'
            ],
            [
                'objek' => 'Sarana Pendidikan Jumlah Siswa ≤ 600',
                'kode' => 'C3',
                'kategori' => '2',
                'jumlah' => '200000'
            ],
            [
                'objek' => 'Sarana Pendidikan Jumlah Siswa > 600',
                'kode' => 'C4',
                'kategori' => '2',
                'jumlah' => '400000'
            ],
            [
                'objek' => 'Fasilitas Umum I (Pura Desa)',
                'kode' => 'D1',
                'kategori' => '2',
                'jumlah' => '30000'
            ],
            [
                'objek' => 'Fasilitas Umum II (Lapangan/Wantilan/dll)',
                'kode' => 'D2',
                'kategori' => '2',
                'jumlah' => '50000'
            ],
            [
                'objek' => 'Pelayanan Panggilan (Event dll)',
                'kode' => 'F1',
                'kategori' => '2',
                'jumlah' => '100000'
            ],
            [
                'objek' => 'Perumahan Per KK / Per Rumah',
                'kode' => 'G1',
                'kategori' => '2',
                'jumlah' => '35000'
            ],
            
        ];

        foreach($distribusis as $distribusi){
            KodeDistribusi::create($distribusi);
        }
    }
}
