<?php

namespace App\Exports;

use App\Models\Pendapatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PendapatansExport implements FromView
{
    public function view(): View
    {
        return view('exports.pendapatans', [
            'pendapatans' => Pendapatan::all()
        ]);
    }
}
