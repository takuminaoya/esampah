<?php

namespace App\Imports;

use App\Models\Banjar;
use App\Models\KodeDistribusi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       //dd($row);
    //    if($row['banjar'] !== null){
    //         $banjar = explode(". ",$row['banjar']);
    //         $banjar_id = Banjar::where('nama',$banjar[1])->value('id');
    //    }
    //    else{
    //         $banjar_id = null;
    //    }
       
    //    $kode_id = KodeDistribusi::where('kode',$row['kode'])->value('id');
    //    $jumlah = KodeDistribusi::where('kode',$row['kode'])->value('jumlah');
    //     return new User([
    //         'nama' => $row['nama'],
    //         'email' => $row['telp'].'@gmail.com',
    //         'password' => '123',
    //         'alamat' => $row['alamat'],
    //         'telp' => $row['telp'],
    //         'banjar_id' => $banjar_id,
    //         'usaha' => $row['nama_usaha'],
    //         'kode_distribusi_id' => $kode_id,
    //         'biaya' => $jumlah,
    //     ]);
     }
}
