<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PembayaransExport implements FromView
{
    public function view(): View
    {
        return view('exports.pembayarans', [
            'pembayarans' => User::all()
        ]);
    }
}
