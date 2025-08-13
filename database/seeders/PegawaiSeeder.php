<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawais = [
            [
                'nama' => 'bendahara',
                'email' => 'bendahara@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'5',
                'nik' => '517836527398',
                'level'=>'bendahara',
            ],
            [
                'nama' => 'petugas',
                'email' => 'petugas@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'4',
                'nik' => '517836527390',
                'level'=>'petugas',
            ],
            [
                'nama' => 'Roni',
                'email' => 'Roni@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'3',
                'nik' => '517836527391',
                'level'=>'petugas',
            ],
            [
                'nama' => 'Harto',
                'email' => 'Harto@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'3',
                'nik' => '517836527392',
                'level'=>'petugas',
            ],
            [
                'nama' => 'Wijaya',
                'email' => 'wijaya@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'2',
                'nik' => '517836527393',
                'level'=>'petugas',
            ],
            [
                'nama' => 'Tama',
                'email' => 'tama@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'2',
                'nik' => '517836527388',
                'level'=>'petugas',
            ],
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'2',
                'nik' => '51783652739',
                'level'=>'admin',
            ]
        ];

        foreach($pegawais as $pegawai){
            Pegawai::create($pegawai);
        }
    }
}
