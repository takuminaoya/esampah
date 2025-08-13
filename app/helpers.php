<?php

use App\Models\DetailJalur;
use App\Models\DetailPembayaran;
use App\Models\Jalur;
use App\Models\Pembayaran;
use App\Models\Pendapatan;
use App\Models\Rekanan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

function getTenggat($user_id){
   $tenggat = Carbon::parse(User::where('id',$user_id)->value('tenggat_bayar'));
    return $tenggat;
}

function getTenggatBayar($tgl){
    $tenggat = Carbon::parse($tgl)->addDays(30);
    return $tenggat;
}

function getMonths($user_id){
    // $sudah_bayar = DetailPembayaran::whereHas('pembayaran',function($q) use($user_id){
    //     $q->where('user_id',$user_id);
    // })->pluck('bulan_bayar');

    $collections = collect();
    for($j=0;$j<2;$j++){
        if($j == 0){
            $year = Carbon::now()->format('Y');
        }else{
            $year = Carbon::now()->addYear()->format('Y');
        }
        //$verified = Carbon::parse(User::where('id',$user_id)->value('tgl_verified'))->format('m');
        for($i=1;$i<=12;$i++){
            $tgl = Carbon::createFromDate($year,$i,1);
            $collections->put($tgl->format('Y-m-d'),$tgl->format('F'));
        }
    }

   // $months = $collections->except($sudah_bayar)->take(12);
    $months = $collections->take(12);
    return $months;
}

function getPelangganBelumLunas(){
    $banjar_id = DetailJalur::whereHas('jalur', function($q){
        $q->where('status',true);
    })->pluck('banjar_id');
    
    $month = Carbon::today()->format('m');
    $year = Carbon::today()->format('Y');
    
    $lunas = Pembayaran::whereHas('detailPembayaran', function($p) use($month,$year){
        $p->whereMonth('bulan_bayar',$month)->whereYear('bulan_bayar',$year);
    })->pluck('user_id');
    
    $pelanggans = User::whereNotIn('id',$lunas)->where('verified',true)->whereIn('banjar_id',$banjar_id)->get();

    // $tenggat_hari_ini = collect();

    // foreach ($belum_lunas as $key => $id){
    //     if(getTenggat($id)->toDateString() == Carbon::today()->toDateString()){
    //         $tenggat_hari_ini->put($key,$id);
    //     }
    // }

    //$pelanggans = User::whereIn('id',$tenggat_hari_ini)->where('verified',true)->get();
    return $pelanggans;
}

function getStatusBayar($user_id){
    $month = Carbon::today()->format('m');
    $year = Carbon::today()->format('Y');

    $lunas = count(Pembayaran::where('status',true)->where('user_id',$user_id)->whereHas('detailPembayaran', function($p) use($month,$year){
        $p->whereMonth('bulan_bayar',$month)->whereYear('bulan_bayar',$year);
    })->get());

    if($lunas !== 0){
        return true;
    }else{
        return false;
    }
}

function getJumlahPelangganRekanan($id){
    $jumlah = count(User::where('rekanan_id',$id)->get());
    return $jumlah;
}
function getMonthsYear(){
   $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
   return $months; 
}

function getJalur($pelanggan_id){
    $jalur = Jalur::whereHas('detailJalur',function($q) use($pelanggan_id){
        $q->whereHas('banjar',function($p) use($pelanggan_id){
            $p->whereHas('user',function($r) use($pelanggan_id){
                $r->where('id',$pelanggan_id);
            });
        });
    })->value('nama');
    return $jalur;
}

function getNamaRekanan($id){
    $nama = Rekanan::where('id',$id)->value('nama');
    return $nama;
}

function getPendapatan($bulan, $isTransfer = null){
    $month = Carbon::parse($bulan)->format('m');
    if($isTransfer == true){
        $pendapatan = Pendapatan::whereMonth('bulan_bayar',$month)->where('isTransfer',true)->get();
    }
    else{
        $pendapatan = Pendapatan::whereMonth('bulan_bayar',$month)->get();
    }
    return $pendapatan;
}

function getDetailPembayaran($user_id){
    $details = DetailPembayaran::whereHas('pembayaran',function($q) use($user_id){
        $q->where('user_id',$user_id);
    })->selectRaw('monthname(bulan_bayar) as bulan, biaya')->pluck('biaya','bulan')->toArray();

    foreach (getMonthsYear() as $month){
        
        if(array_key_exists(Carbon::parse($month)->format('F'),$details) == false){
            $details[Carbon::parse($month)->format('F')] = 0;
        }
    }
    $total = DetailPembayaran::whereHas('pembayaran',function($q) use($user_id){
        $q->where('user_id',$user_id);
    })->selectRaw('sum(biaya) as total, biaya')->value('total');

    $details['total'] = $total;
    // dd($details);
    return $details;
}



        
