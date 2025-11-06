<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Banjar;
use App\Models\DetailJalur;
use App\Models\DetailPembayaran;
use App\Models\KodeDistribusi;
use App\Models\Pembayaran;
use App\Models\Rekanan;
use App\Models\StatusPelanggan;
use App\Models\User;
use App\Services\CustomerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {set_time_limit(0);
        $months = getMonthsYear();
        if (Auth::user()->level == 'admin' || Auth::user()->level == 'bendahara'){
            $rekanans = Rekanan::get(['id','nama']);
            if ($request->group){
                $req = $request->group;
                $pelanggans = User::where('verified',true)->where('rekanan_id',1)->whereHas('banjar', function($q) use($req){
                    $q->whereHas('detailJalur',function($p) use($req){
                        $p->whereHas('jalur', function($r) use($req){
                            $r->where('nama', $req);
                        });
                    });
                })->paginate(25)->withQueryString();
            }
            elseif ($request->rekanan){
                $req = $request->rekanan;
                $pelanggans = User::where('verified',true)->whereHas('rekanan', function($q) use($req){
                    $q->where('id',$req);
                })->paginate(25)->withQueryString();
            }
            else{
                $pelanggans = User::where('verified',true)->where('rekanan_id',1)->paginate(25)->withQueryString();
            }
            return view('pelanggan.index',compact(['pelanggans','rekanans','months']));
        }
    }
    
    public function create()
    {
        $distribusis = KodeDistribusi::all();
        $banjars = DB::connection('ungasan')->table('banjars')->get();
        $rekanans = Rekanan::all();
        return view('pelanggan.create',compact(['distribusis','banjars','rekanans']));
    }

    public function store(Request $request){
        list($partnerCode, $customerCode) = $this->customerService->generateCustomerCode($request->rekanan);
        $tgl_verified = Carbon::today()->toDateString();
        $tenggat = getTenggatBayar($tgl_verified);
        
        $request->validate([
            'kategori' => 'required',
            'nama' => 'required',
            'nik'  => 'required',
            'alamat' => 'required',
            'telp'  => 'required',
            'banjar' => 'required',
            'rekanan' => 'required',
        ]);
    
        if ($request->password == $request->konfirmasi_password){
            $user = User::create([
                'nama' => $request->nama,
                'kode_distribusi_id' => $request->kategori,
                'nik'  => $request->nik,
                'alamat' => $request->alamat,
                'telp'  => $request->telp,
                'usaha' => $request->nama_usaha,
                'banjar_id' => $request->banjar,
                'kode_pelanggan' => $customerCode,
                'kode_rekanan' => $partnerCode,
                'biaya' => $request->biaya,
                'rekanan_id' => $request->rekanan,
                'verified' => true,
                'tgl_verified' => $tgl_verified,
                'username' => $customerCode,
                'password' => bcrypt('123'),
                'tenggat_bayar' => $tenggat
            ]);
            return redirect('pelanggan')
                ->with('status','success')
                ->with('message','Pelanggan berhasil ditambahkan');
        }
    }

    public function edit(User $pelanggan){
        $distribusis = KodeDistribusi::all();

        $token = env('TOKEN_API');
        $url = 'https://ungasan.silagas.id/api/banjar?token='.$token;
        $response = Http::get($url);
        $datas = $response->object();
        $banjars = $datas->data;

        $rekanans = Rekanan::all();

        return view('pelanggan.edit',compact(['pelanggan','distribusis','banjars','rekanans']));
    }

    public function update(Request $request, User $pelanggan)
    {
        list($partnerCode, $customerCode) = $this->customerService->generateCustomerCode($request->rekanan);
    
        $edit = $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'banjar_id' => 'required',
            'telp' => 'required',
            'biaya' => 'required',
            'kode_distribusi_id' => 'required',
            'rekanan_id' => 'required',
        ]);

        $pelanggan->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'banjar_id' => $request->banjar_id,
            'telp' => $request->telp,
            'biaya' => $request->biaya,
            'kode_distribusi_id' => $request->kode_distribusi_id,
            'rekanan_id' => $request->rekanan_id,
            'kode_pelanggan' => $customerCode,
            'kode_rekanan' => $partnerCode
        ]);

        return redirect('pelanggan')
            ->with('status','success')
            ->with('message','Data berhasil diedit');
    }

    public function updateStatus(User $user)
    {
        try {
            $result = $user->status 
                ? $this->customerService->deactivateCustomer($user)
                : $this->customerService->activateCustomer($user);
            
            return redirect()->back()
                ->with('status', $result['status'])
                ->with('message', $result['message']);
        } catch (\Exception $e) {
            Log::error('Error updating customer status: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', 'Gagal mengubah status pelanggan');
        }
    }

    public function destroy(User $user){
        $user->delete();

        return redirect()->back()
            ->with('status','success')
            ->with('message','Pelanggan berhasil dihapus');
    }

    public function cetak( Request $request)
    {
        set_time_limit(0);
        if (Auth::user()->level == 'bendahara' || Auth::user()->level == 'admin'){
            if ($request->group){
                $req = $request->group;
                $pelanggans = User::where('verified',true)->where('rekanan_id',1)->whereHas('banjar', function($q)  use($req){
                    $q->whereHas('detailJalur',function($p)  use($req){
                        $p->whereHas('jalur', function($r) use($req){
                            $r->where('nama', $req);
                        });
                    });
                })->get();
            }
            else{
                $pelanggans = User::where('verified',true)->where('rekanan_id',1)->get();
            }
            return view('pelanggan.cetak',compact(['pelanggans']));
        }
    }

    public function import(){
        set_time_limit(0);
        $users = Excel::toCollection(new UsersImport, request()->file('file'));
        $i = 1;
        foreach($users[0] as $row){
            if($row['banjar'] !== null){
                $banjar = explode(". ",$row['banjar']);
                $banjar_id = Banjar::where('nama',$banjar[1])->value('id');
            }
            else{
                $banjar_id = null;
            }
            $kode_id = KodeDistribusi::where('kode',$row['kode'])->value('id');
            $jumlah = KodeDistribusi::where('kode',$row['kode'])->value('jumlah');

            $tgl_verified = Carbon::today()->toDateString();
            $tenggat = getTenggatBayar($tgl_verified);
            
            $user = User::create([
                'nama' => $row['nama'],
                'username' => 'user'.$i,
                'password' => bcrypt('123'),
                'kode_rekanan' => $i,
                'kode_pelanggan' => 'cub'.str_pad($i,4,'0',STR_PAD_LEFT),
                'alamat' => $row['alamat'],
                'telp' => $row['telp'],
                'banjar_id' => $banjar_id,
                'usaha' => $row['nama_usaha'],
                'kode_distribusi_id' => $kode_id,
                'biaya' => $jumlah,
                'rekanan_id' => 1,
                'verified' => true,
                'tgl_verified' => $tgl_verified,
                'tenggat_bayar' => $tenggat
            ]);
            $i++;
            $months = array_map('strtolower', getMonthsYear());
            foreach($months as $month){
                $bulan = Carbon::parse($month)->format('m');
                if($row[$month.'_cash'] !== null){
                    $total = $row[$month.'_cash'];
                    $isTransfer = true;
                    $bukti_bayar = null;
                    $tes = Pembayaran::create([
                        'user_id' => $user->id,
                        'pegawai_id' => 1,
                        'status' => 1,
                        'verifikasi_bendahara' => 1,
                        'total' => $total,
                        'isTransfer' => $isTransfer,
                        'jumlah_bulan' => 1,
                        'bukti_bayar' => $bukti_bayar,
        
                    ]);
                    DetailPembayaran::create([
                        'pembayaran_id' => $tes->id,
                        'user_id' => $user->id,
                        'bulan_bayar'=>'2022-'.$bulan.'-01',
                        'biaya'=>$total
                    ]);
                }
                elseif($row[$month.'_trf'] !== null){
                    $total = $row[$month.'_trf'];
                    $isTransfer = false;
                    $bukti_bayar = "tes";
                    $tes = Pembayaran::create([
                        'user_id' => $user->id,
                        'pegawai_id' => 1,
                        'status' => 1,
                        'verifikasi_bendahara' => 1,
                        'total' => $total,
                        'isTransfer' => $isTransfer,
                        'jumlah_bulan' => 1,
                        'bukti_bayar' => $bukti_bayar,
                    ]);
                    DetailPembayaran::create([
                        'pembayaran_id' => $tes->id,
                        'user_id' => $user->id,
                        'bulan_bayar'=>'2022-'.$bulan.'-01',
                        'biaya'=>$total
                    ]);
                }
            }
            
        }

    //     set_time_limit(0);
    //     $users = Excel::toCollection(new UsersImport, request()->file('file'));
    //      $tgl_verified = Carbon::today()->toDateString();
    
    //     foreach($users[0] as $row){
    //         $last_kode = User::where('verified',true)
    //         ->where('rekanan_id',$row['rekanan'])
    //         ->latest()
    //         ->value('kode_rekanan');

    //         $kode_rekanan = $last_kode+1;
    //         $kode = str_pad($kode_rekanan,4,'0',STR_PAD_LEFT);

    // // char
    //         $nama_rekanan = Rekanan::where('id',$row['rekanan'])->value('nama');
    //         $words = explode(" ", $nama_rekanan);
    //         $acronym = "";

    //         foreach ($words as $w) {
    //             $acronym .= mb_substr($w, 0, 1);
    //         }
    //         $slug_rekanan = strtolower($acronym);

    //         $kode_pelanggan = $slug_rekanan.$kode;

    //         $user = User::create([
    //             'nama' => $row['nama'],
    //             'email' => null,
    //             'password' => '123',
    //             'username' => $kode_pelanggan,
    //             'alamat' => $row['alamat'],
    //              'kode_pelanggan' => $kode_pelanggan,
    //              'kode_rekanan' => $kode_rekanan,
    //             'telp' => null,
    //             'banjar_id' => null,
    //             'verified' => true,
    //             'usaha' => null,
    //             'kode_distribusi_id' => null,
    //             'biaya' => null,
    //             'rekanan_id' => $row['rekanan'],
    //             'tgl_verified' => $tgl_verified
    //         ]);

    //         $months = ['jan','feb','mar','apr','may'];
    //         foreach($months as $month){
    //             $bulan = Carbon::parse($month)->format('m');
    //             if($row[$month] !== null){
    //                 $total = $row[$month];
    //                 $tes = Pembayaran::create([
    //                     'user_id' => $user->id,
    //                     'pegawai_id' => 1,
    //                     'status' => 1,
    //                     'verifikasi_bendahara' => 1,
    //                     'total' => $total,
    //                     'isTransfer' => false,
    //                     'jumlah_bulan' => 1,
    //                 ]);
    //                 DetailPembayaran::create([
    //                     'pembayaran_id' => $tes->id,
    //                     'bulan_bayar'=>'2022-'.$bulan.'-01',
    //                     'biaya'=>$total
    //                 ]);
    //             }
    //         }
            
    //     }

        
        return redirect('pelanggan')->with('success', 'All good!');
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
