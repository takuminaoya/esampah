<?php

namespace App\Http\Controllers;

use App\Models\DetailPembayaran;
use App\Models\KodeDistribusi;
use App\Models\Pegawai;
use App\Models\Pembayaran;
use App\Models\Pendapatan;
use App\Models\Rekanan;
use App\Models\StatusPelanggan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function getVerifikasiPelanggan(){
        $pelanggans = User::where('verified',0)->get();
        $distribusis = KodeDistribusi::all();
        $rekanans = Rekanan::all();
        return view('verifikasi.verify-pelanggan',compact(['pelanggans','distribusis','rekanans']));
    }

    public function postVerifikasiPelanggan(Request $request, User $user)
    {
        $jumlah = str_replace(',', '', $request->biaya);

        $last_kode = User::where('verified',true)
            ->where('rekanan_id',$request->rekanan)
            ->latest()
            ->value('kode_rekanan');

        $kode_rekanan = $last_kode+1;

        $kode_pelanggan = getKodePelanggan($request->rekanan);

        $tgl_verified = Carbon::today()->toDateString();
        $tenggat = getTenggatBayar($tgl_verified);

        $request->validate([
            'biaya' => 'required'
        ]);

        User::where('id',$user->id)->update([
            'verified'=>1,
            'rekanan_id' => $request->rekanan,
            'tgl_verified' => $tgl_verified,
            'biaya' => $jumlah,
            'tenggat_bayar' => $tenggat,
            'kode_rekanan' => $kode_rekanan,
            'kode_pelanggan' => $kode_pelanggan
        ]);

        StatusPelanggan::create([
            'user_id' => $user->id,
            'bulan' => Carbon::today()->format('Y-m'),
            'status' => true
        ]);
        
        return redirect()->back()
                ->with('status','success')
                ->with('message','Akun telah diverifikasi');
    }

    public function getVerifikasiTransfer(){
        $transfers = Pembayaran::where('isTransfer',true)->where('verifikasi_bendahara',false)->get();
        $details = DetailPembayaran::whereHas('pembayaran', function($q){
            $q->where('isTransfer',true)->where('verifikasi_bendahara',false);
        })->get();

        return view('verifikasi.verify-transfer',compact(['transfers','details']));
    }

    public function postVerifikasiTransfer(Pembayaran $pembayaran){
        $pembayaran->update(['verifikasi_bendahara'=>true]); 

        $this->storePendapatanByVerifikasi($pembayaran);

        return redirect()->back()
            ->with('status','success')
            ->with('message','Pembayaran berhasil diverifikasi');
    }

    public function storePendapatanByVerifikasi($pembayaran){
        $details = DetailPembayaran::where('pembayaran_id',$pembayaran->id)->get();

        foreach ($details as $key => $detail) {
            $pendapatan = [
                'bulan_bayar' => $detail->bulan_bayar,
                'isTransfer' => $pembayaran->isTransfer,
                'jumlah' => $detail->biaya,
                'pembayaran_id'=> $pembayaran->id
            ];

            if ($pembayaran->isTransfer == true){
                $pendapatan['keterangan'] = 'Transfer '.$pembayaran->user->nama;
            }else{
                $pendapatan['keterangan'] = "Collect umum bulan ".Carbon::parse($detail->bulan_bayar)->format('F');
            }

            Pendapatan::create($pendapatan);
        }
    }

    public function getVerifikasiSetoran(){
        $totals = Pembayaran::whereHas('pegawai', function($q){
            $q->where('level','petugas');
        })->where('status',true)->where('verifikasi_bendahara',false)->groupBy('pegawai_id')->selectRaw('pegawai_id,sum(total) as total')->get();

        $petugass = Pegawai::with('pembayaran')->whereHas('pembayaran', function($q){
            $q->where('status',true)->where('verifikasi_bendahara',false);
        })->get();

        return view('verifikasi.verify-setoran',compact(['totals','petugass']));
    }

    public function postVerifikasiSetoran(Pegawai $petugas, Request $request){

        Pembayaran::whereIn('id',$request->setoran)
            ->update(['verifikasi_bendahara' => true]);

        $pembayarans = Pembayaran::whereIn('id',$request->setoran)->get();

        foreach ($pembayarans as $key => $pembayaran) {
            $this->storePendapatanByVerifikasi($pembayaran);
        }

        return redirect()->back()
            ->with('status','success')
            ->with('message','Setoran berhasil diverifikasi');
    }

    public function getNonaktif(){
        $pelanggans = User::where('verified',true)->where('status',false)->get();
        return view('verifikasi.nonaktif',compact('pelanggans'));
    }

    public function getKadaluarsa(Request $request){
        if(!$request->waktu){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','<',Carbon::today()->subDays(90)->format('Y-m-d'))
                ->get();
        }elseif($request->waktu == "1"){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','=',Carbon::today()->subDays(89)->format('Y-m-d'))
                ->get();
        }elseif($request->waktu == "3"){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','=',Carbon::today()->subDays(87)->format('Y-m-d'))
                ->get();
        }
        
        return view('verifikasi.kadaluarsa',compact('pelanggans'));
    }

    // public function postKadaluarsa(User $user){
    //     $user->update(['status' => 0]);
     
    //     return redirect()->back()
    //         ->with('status','success')
    //         ->with('message','User dianonaktifkan');  
    // }

    public function sync(){
        set_time_limit(0);
        $t = User::where('verified',true)->where('rekanan_id',1)->get();
        foreach ($t as $key => $user) {
            $jumlah = count(StatusPelanggan::where('user_id',$user->id)->whereHas('user', function($q){
                $q->where('rekanan_id',1);
            })->where('bulan',Carbon::today()->format('Y-m'))->get());
            if($user->status == false && $jumlah == 0){
                StatusPelanggan::create([
                    'user_id' => $user->id,
                    'bulan' => Carbon::today()->format('Y-m'),
                    'status' => false
                ]);
            }
            elseif($user->status == true && $jumlah == 0){
                StatusPelanggan::create([
                    'user_id' => $user->id,
                    'bulan' => Carbon::today()->format('Y-m'),
                    'status' => true
                ]);
            }
        }
        //update tenggat bayar (CASE 1)
        $users = User::where('status',true)->where('tenggat_bayar','<',Carbon::today()->format('Y-m-d'))->get();
       
        $update_tenggat = 0;

        $array = [];
        foreach ($users as $user){
            $id = User::where('id',$user->id)->whereHas('pembayaran', function($q) use($user){
                $q->where('verifikasi_bendahara',true)->whereHas('detailPembayaran',function($p) use($user){
                    $p->whereMonth('bulan_bayar',Carbon::parse($user->tenggat_bayar)->subDays(30)->format('m'));
                });
            })->value('id');
            array_push($array,$id);
            $jml = User::where('id',$id)->update(['tenggat_bayar' => getTenggatBayar($user->tenggat_bayar)]);

            $update_tenggat = $update_tenggat + $jml;

        }
       // CREATE STATUS (CASE 1)
        // foreach ($array as $key => $id) {
        //     $tenggat = User::where('id',$id)->value('tenggat_bayar');
        //     if($id !== null){
        //         StatusPelanggan::create([
        //             'user_id' => $id,
        //             'bulan' => Carbon::parse($tenggat)->addDays(90)->format('Y-m'),
        //             'status' => true
        //         ]);
        //         // User::where('id',$id)->update(['status' => true]);
        //     }
        // }
        // SELESAI
       
        // $overdues = User::where('status',true)->where('tenggat_bayar','<',Carbon::today()->subDays(90))->get();
        // // update status pelanggan
        // $user_nonaktif = 0;
        // foreach ($overdues as $user){
        //    $jml = User::where('id',$user->id)->update(['status' => false]);
        //     StatusPelanggan::create([
        //         'user_id' => $user->id,
        //         'bulan' => Carbon::parse($user->tenggat_bayar)->addDays(90)->format('Y-m'),
        //         'status' => false
        //     ]);
        //     $user_nonaktif = $user_nonaktif + $jml;
        // }
        

        // $overdues = User::where('status',false)->
        // User::where('')
        // $tes = User::where('status',false)->where('tenggat_bayar','<',Carbon::today()->format('Y-m-d'))->get();

        // foreach ($tes as $user){
        //     $id = User::where('id',$user->id)->whereHas('pembayaran', function($q) use($user){
        //         $q->where('verifikasi_bendahara',true)->whereHas('detailPembayaran',function($p) use($user){
        //             $p->whereMonth('bulan_bayar',Carbon::parse($user->tenggat_bayar)->subDays(30)->format('m'));
        //         });
        //     })->value('id');
        //     array_push($array,$id);
        //     $jml = User::where('id',$id)->update(['tenggat_bayar' => getTenggatBayar($user->tenggat_bayar)]);

       
        //     $update_tenggat = $update_tenggat + $jml;

        // }

        // $bulan = StatusPelanggan::where('user_id',$id)->orderBy('bulan','DESC')->value('bulan');
        // Carbon::parse($bulan)->addDays(30)->format('m');

        // $aktif = User::where('status',false)->where('tenggat_bayar','<',Carbon::today()->subDays(90))->get();
        return redirect()->back()
            ->with('status','success')
            ->with('message',$update_tenggat.' user berhasil diupdate');
    }
}
