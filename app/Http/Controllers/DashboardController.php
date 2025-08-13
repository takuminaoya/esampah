<?php

namespace App\Http\Controllers;

use App\Models\Banjar;
use App\Models\DetailJalur;
use App\Models\Pembayaran;
use App\Models\Pengambilan;
use Illuminate\Http\Request;
use App\Models\Jalur;
use App\Models\StatusPelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // user
        if(Auth::user()->level == false){
            $tgl_tenggat = Carbon::parse(User::where('id',Auth::id())
                ->value('tenggat_bayar'))
                ->isoFormat('dddd, D MMMM Y');
                
            $bln_tenggat = getTenggat($user_id)->isoFormat('MMMM');

            $pengambilan_terakhir = Pengambilan::where('user_id',$user_id)
                ->orderBy('created_at','DESC')
                ->first();

            $pengambilan_hari_ini = Pengambilan::where('user_id',$user_id)
                ->where('created_at',Carbon::today())
                ->get(['status','pegawai_id']);

            return view('dashboard.dashboard',compact(['tgl_tenggat','bln_tenggat','pengambilan_terakhir','pengambilan_hari_ini']));
        }

        // petugas
        elseif (Auth::user()->level == 'petugas')
        { 
            $banjar_id = DetailJalur::whereHas('jalur', function($q){
                $q->where('status',true);
            })->pluck('banjar_id');

            //jadwal pembayaran
            $pembayaran = count(
                User::whereIn('banjar_id',$banjar_id)
                    ->where('verified',true)
                    ->where('rekanan_id',1)
                    ->get()
            );

            //pengambilan
            
            $sudah_ambil = Pengambilan::whereDate('created_at',Carbon::now()->toDateString())
                ->pluck('user_id');

            $pengambilan = count(
                User::whereIn('banjar_id',$banjar_id)
                    ->where('verified',true)
                    ->where('status',true)
                    ->where('rekanan_id',1)
                    ->whereNotIn('id',$sudah_ambil)
                    ->get()
            );

            $pengambilan_terakhir = Pengambilan::where('pegawai_id',$user_id)
                ->orderBy('created_at','DESC')
                ->first();

            //setoran
            $setoran = Pembayaran::where('pegawai_id',$user_id)
                ->where('verifikasi_bendahara',false)
                ->groupBy('pegawai_id')
                ->selectRaw('sum(total) as total')
                ->value('total');

            return view('dashboard.dashboard',compact(['pengambilan','pembayaran','pengambilan_terakhir','setoran']));
        }

        // bendahara
        elseif (Auth::user()->level == 'bendahara'){
            $transfer = count(Pembayaran::where('isTransfer',true)->where('verifikasi_bendahara',false)->get());
            $belum_setor = Pembayaran::where('isTransfer',false)->where('verifikasi_bendahara',false)->selectRaw('sum(total) as total')->value('total');
            $pend_bulan = Pembayaran::whereHas('detailPembayaran', function($q){
                $q->whereMonth('bulan_bayar',Carbon::today()->format('m'));
            })->where('status',true)->where('verifikasi_bendahara',true)->selectRaw('sum(total/jumlah_bulan) as total')->value('total');
            // dd($pend_bulan);
            $verifikasi_akhir = Pembayaran::where('status',true)->where('verifikasi_bendahara',true)->orderBy('updated_at','DESC')->first();
            $pend_tahun = Pembayaran::whereHas('detailPembayaran', function($q){
                $q->whereYear('bulan_bayar',Carbon::today()->format('Y'));
            })->where('status',true)->where('verifikasi_bendahara',true)->selectRaw('sum(total/jumlah_bulan) as total')->value('total');
            // dd($pend_bulan);
            return view('dashboard.dashboard',compact(['transfer','belum_setor','pend_bulan','pend_tahun', 'verifikasi_akhir']));
        }
        
        // admin
        elseif (Auth::user()->level == 'admin')
        {
            $unverified = count(User::where('verified',false)->get());
            $pelanggans = count(User::where('verified',true)->where('rekanan_id',1)->get());
            $nonaktifs = count(User::where('verified',true)->where('rekanan_id',1)->where('status',false)->get());
            $overdue = count(User::where('verified',true)->where('rekanan_id',1)->where('status',true)->where('tenggat_bayar','<',Carbon::today()->subDays(90)->format('Y-m-d'))->get());
            return view('dashboard.dashboard',compact(['unverified','pelanggans','nonaktifs','overdue']));
        }
    }

    public function getSingleChartPelanggan(){
        $banjars_id = Banjar::pluck('id');
        $banjars = Banjar::pluck('nama');
        $pelanggans = User::where('verified',true)->where('rekanan_id',1)
                ->selectRaw("banjar_id, count(case when verified = '1' then 1 end) as jumlah")
                ->groupBy('banjar_id')
                ->get()->toArray();
        $data_pelanggans = [];
        foreach ($banjars_id as $key => $banjar_id) {
            $key = array_search($banjar_id, array_column($pelanggans, 'banjar_id'));
            $data = $key === false ? 0 : $pelanggans[$key]['jumlah'];
            array_push($data_pelanggans, $data);
        }
        //$jumlah = DetailBarang::orderBy('barangs_id')->groupBy('barangs_id')->selectRaw('sum(jumlah) as sum')->pluck('sum');
        return response()->json(array($banjars,$data_pelanggans));
    }

    public function getDonutChartPelanggan(){
        $aktif = count(User::where('verified',true)->where('rekanan_id',1)->where('status',true)->get());
        $nonaktif = count(User::where('verified',true)->where('rekanan_id',1)->where('status',false)->get());
        $jumlah = [];
        array_push($jumlah,$aktif);
        array_push($jumlah,$nonaktif);
        return response()->json($jumlah);
    }

    public function getSalesChartPelanggan(){
        $months = getMonthsYear();
        $aktifs = [];
        $nonaktifs = [];
        $totals = [];

       foreach($months as $month){

            $jml_aktif = count(StatusPelanggan::where('bulan',Carbon::parse($month)->format('Y-m'))->where('status',true)
            ->whereHas('user', function($q){
                $q->where('rekanan_id',1);
            })->get());
            
            array_push($aktifs,$jml_aktif);

            $jml_nonaktif = count(StatusPelanggan::where('bulan',Carbon::parse($month)->format('Y-m'))->where('status',false)
            ->whereHas('user', function($q){
                $q->where('rekanan_id',1);
            })->get());
            array_push($nonaktifs,$jml_nonaktif);

            $total = $jml_aktif + $jml_nonaktif;
            array_push($totals,$total);
       }
       
        return response()->json(array($aktifs,$nonaktifs,$totals));
    }
}