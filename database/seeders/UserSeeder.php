<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nama' => 'pelanggan',
                'email' => 'pelanggan@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'089678678678',
                'banjar_id'=>'1',
                'nik' => '517836527358',
                'kode_distribusi_id'=> '1',
                'biaya' => '30000',
                'verified'=>true,
                'tgl_verified'=> Carbon::today()->toDateString(),
                'tenggat_bayar' => Carbon::today()->addDays(30)->toDateString(),
                'rekanan_id' => 1
            ],
            [
                'nama' => 'Wahyu',
                'email' => 'wahyu@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'08967867808',
                'banjar_id'=>'2',
                'kode_distribusi_id'=> '1',
                'nik' => '517836526396',
                'verified'=>false,
            ],

            [
                'nama' => 'Dode',
                'email' => 'dode@gmail.com',
                'password'=> bcrypt('123'),
                'alamat'=> 'Jalan Imam Bojol No.1',
                'telp'=>'08967867808',
                'banjar_id'=>'3',
                'kode_distribusi_id'=> '1',
                'nik' => '517836526300',
                'verified'=>false,
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
