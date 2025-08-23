<?php

namespace App\Http\Controllers;

use App\Exports\PembayaransExport;
use App\Models\Banjar;
use App\Models\DetailJalur;
use App\Models\DetailPembayaran;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Jalur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {   
        $months = getMonthsYear();
        if(Auth::user()->level == false){
            $pembayarans = DetailPembayaran::where('user_id',Auth::id())->orderBy('created_at','DESC')->limit(10)->get();
        }
        elseif(Auth::user()->level == 'petugas'){
            $pembayarans = Pembayaran::where('pegawai_id',Auth::id())->orderBy('created_at','DESC')->limit(10)->get();
        }else{
            $pembayarans = User::where('verified',true)->where('rekanan_id',1)->limit(10)->get(['id','kode_pelanggan','nama','biaya']);
        }
        return view('pembayaran.index',compact(['pembayarans','months']));
    }

    public function getJadwal(){

        $banjar_id = DetailJalur::whereHas('jalur', function($q){
            $q->where('status',true);
        })->pluck('banjar_id');

        $pelanggans = User::where('verified',true)->where('rekanan_id',1)->whereIn('banjar_id',$banjar_id)->get();
        //$pelanggans = User::whereNotIn('id',$lunas)->get();
       
        return view('pembayaran.jadwal',compact('pelanggans'));
    }

    public function create(User $pelanggan){
        $id = $pelanggan->id;

        return view('pembayaran.create',compact(['pelanggan','id']));
    }

    public function store(Request $request){
        
        $total = str_replace(',', '', $request->total);

        $req = [
            'bulan_bayar' => 'required',
            'total' => 'required',
            'isTransfer' => 'required'
        ];

        if($request->isTransfer == true){
            $req['bukti_bayar'] = 'required|image|file|max:1024';
        }

        $request->validate($req);

        $jumlah_bulan = count($request->bulan_bayar);

        if($request->isTransfer == true){
            $pembayaran = Pembayaran::create([
                'user_id' => $request->id,
                'status' => false,
                'isTransfer' => true,
                'bukti_bayar' => $request->file('bukti_bayar')->store('bukti-bayar'),
                'total'=> $total,
                'jumlah_bulan' => $jumlah_bulan
            ]);
        }else{
            $pembayaran = Pembayaran::create([
                'user_id' => $request->id,
                'pegawai_id' => Auth::id(),
                'status' => true,
                'total'=> $total,
                'jumlah_bulan' => $jumlah_bulan
            ]);
        }

        foreach($request->bulan_bayar as $key => $value){
            DetailPembayaran::create([
                'pembayaran_id'=> $pembayaran->id,
                'bulan_bayar' => $value,
                'user_id' => $request->id,
                'biaya' => $request->biaya
            ]);
        }

        return redirect()->back()
            ->with('status','success')
            ->with('message','Pembayaran berhasil diinput');
    }


    public function getTransfer(){
        $id = Auth::id();
        $biaya = Auth::user()->biaya;
        return view('pembayaran.create-transfer',compact(['id','biaya']));
    }

    public function cetak(Request $request){
        set_time_limit(0);
        if (Auth::user()->level == 'bendahara' || Auth::user()->level == 'admin'){
            $months = getMonthsYear();
            if(!$request->rekanan){
                $pelanggans = User::where('verified',1)->where('rekanan_id',1)->with('pembayaran')->get();
            }else{
                $pelanggans = User::where('verified',1)->where('rekanan_id',$request->rekanan)->with('pembayaran')->get();
            }

            $jumlah = [];
            $subtotal = 0;
            foreach (getMonthsYear() as $month){
                if(!$request->rekanan){
                    $total = DetailPembayaran::whereHas('pembayaran', function($q){
                        $q->where('verifikasi_bendahara',true);
                    })
                    ->whereMonth('bulan_bayar',Carbon::parse($month)->format('m'))
                    ->selectRaw('sum(biaya) as biaya')
                    ->value('biaya');

                    array_push($jumlah,$total);

                    $subtotal = $subtotal + $total;

                }else{
                    $id = $request->rekanan;
                    $bayar = DetailPembayaran::whereHas('pembayaran', function($q) use($id){
                        $q->where('verifikasi_bendahara',true)->whereHas('user',function($p) use($id){
                                $p->where('rekanan_id',$id);
                            });
                        })
                        ->whereMonth('bulan_bayar',Carbon::parse($month)->format('m'))
                        ->selectRaw('sum(biaya) as biaya')
                        ->value('biaya');

                    if($bayar == null){
                        $bayar = 0;
                    }
                    array_push($jumlah,$bayar);
                    $subtotal = $subtotal + $bayar;
                }
            }
        }
            //dd($users[1]);
            return view('pelanggan.cetak',compact(['pelanggans','jumlah','subtotal','months']));
    }

    public function export() 
    {
        return Excel::download(new PembayaransExport, 'pembayarans.xlsx');
    }

}
