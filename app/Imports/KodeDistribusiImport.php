<?php

namespace App\Imports;

use App\Models\KodeDistribusi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KodeDistribusiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new KodeDistribusi([
            'objek' => $row['objek'],
            'kode' => $row['kode'],
            'kategori' => $row['kategori'],
            'jumlah' => $row['jumlah'],
        ]);
    }
}
