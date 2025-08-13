<?php

namespace App\Http\Controllers;

use App\Models\Banjar;
use App\Models\DetailJalur;
use App\Models\DetailPembayaran;
use App\Models\Pembayaran;
use App\Models\Pengambilan;
use App\Models\User;
use App\Models\Jalur;
use Carbon\Carbon;
use Cron\MonthField;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PengambilanController extends Controller
{
    public function index()
    {   
        $user_id = Auth::id();
        if(Auth::user()->level == false){
            $pengambilans = Pengambilan::where('user_id',$user_id)->orderBy('created_at','DESC')->get();
        }
        elseif(Auth::user()->level == 'petugas'){
            $pengambilans = Pengambilan::where('pegawai_id',$user_id)->orderBy('created_at','DESC')->get();
        }
        return view('pengambilan.index',compact('pengambilans'));
    }

    public function getJadwal(){
        //ambil pengambilan sesuai jalur
        $sudah_ambil = Pengambilan::whereDate('created_at',Carbon::now()->toDateString())->pluck('user_id');
        $banjar_id = DetailJalur::whereHas('jalur', function($q){
            $q->where('status',true);
        })->pluck('banjar_id');
        $pelanggans = User::where('verified',true)
            ->where('status',true)
            ->where('rekanan_id',1)
            ->whereIn('banjar_id',$banjar_id)
            ->whereNotIn('id',$sudah_ambil)
            ->orderBy('banjar_id','ASC')
            ->get(['id','nama','banjar_id','alamat','kode_pelanggan']);
        

        $month = Carbon::now()->format('m');
        
        $id = $pelanggans->pluck('id');
        $banjars = Banjar::whereHas('user', function($q) use($id){
            $q->whereIn('id',$id);
        })->get();

        return view('pengambilan.jadwal',compact(['pelanggans','banjars']));
    }

    public function create(User $pelanggan){
        $id = $pelanggan->id;

        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $status = Pembayaran::where('user_id',$id)
            ->whereHas('detailPembayaran', function($p) use($month,$year){
                $p->whereMonth('bulan_bayar',$month)->whereYear('bulan_bayar',$year);
            })->value('status');

        return view('pengambilan.create',compact(['pelanggan','status']));
    }

    public function store(Request $request){
        // ambil
        $req = [
            'status' => 'required',
            'gambar' => 'image|file|max:1024'
        ];

        // tidak ambil
        if ($request->status == 2){
            $req['alasan'] ='required';
        }

        //langsung bayar
        $pembayaran = [];

        if ($request->status_bayar == 1){
            $total = str_replace(',', '', $request->total);
            $req['bulan_bayar'] = 'required';

            $pembayaran = [
                'user_id' => $request->id,
                'pegawai_id' => Auth::id(),
                'status' => 1,
                'verifikasi_bendahara' => false,
                'total'=> $total,
            ];
        }

        $request->validate($req);

        if ($request->status == 1){
            Pengambilan::create([
                'user_id' => $request->id,
                'status' => $request->status,
                'gambar' => $request->file('gambar')->store('gambar-sampah'),
                'pegawai_id' => Auth::id()
            ]);
        } elseif ($request->status == 2){
            Pengambilan::create([
                'user_id' => $request->id,
                'status' => $request->status,
                'gambar' => $request->file('gambar')->store('gambar-sampah'),
                'pegawai_id' => Auth::id(),
                'alasan' => $request->alasan
            ]);
        }

        if (count($pembayaran) !== 0){
            $pembayaran['jumlah_bulan'] = count($request->bulan_bayar);
            $bayar = Pembayaran::create($pembayaran);
            foreach($request->bulan_bayar as $key => $value){
                DetailPembayaran::create([
                    'pembayaran_id'=> $bayar->id,
                    'bulan_bayar' => $value,
                    'user_id' => $request->id,
                    'biaya' => $request->biaya
                ]);
            }
        }

        return redirect('pengambilan/jadwal')
                ->with('status','success')
                ->with('message','Pengambilan berhasil diinput');
    }
}
