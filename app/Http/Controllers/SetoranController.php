<?php

namespace App\Http\Controllers;

use App\Models\DetailJalur;
use App\Models\DetailPembayaran;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function index(){
        if(Auth::user()->level == 'petugas'){
            $setorans = Pembayaran::where('pegawai_id',Auth::id())->where('verifikasi_bendahara',false)->get();
        }
        elseif(Auth::user()->level == 'bendahara'){
            $setorans = DetailPembayaran::whereYear('created_at',Carbon::today()->format('Y'))
            ->selectRaw('month(bulan_bayar) month,sum(biaya) as biaya')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        }
        return view('setoran.index',compact('setorans'));
    }

    public function cetak(){
        $setorans = DetailPembayaran::whereYear('created_at',Carbon::today()->format('Y'))
            ->selectRaw('month(bulan_bayar) month,sum(biaya) as biaya')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return view('setoran.cetak',compact('setorans'));
    }

}
