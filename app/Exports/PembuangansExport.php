<?php

namespace App\Exports;

use App\Models\Pembuangan;
use Maatwebsite\Excel\Concerns\FromCollection;

class PembuangansExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pembuangan::all();
    }
}
