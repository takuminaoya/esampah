<?php

namespace App\Http\Controllers;

use App\Imports\KodeDistribusiImport;
use App\Imports\UsersImport;
use App\Models\JenisPendapatan;
use App\Models\Pendapatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendapatanController extends Controller
{
    public function index(Request $request)
    { set_time_limit(0);
        if($request->isTransfer){
            $pendapatans = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->where('isTransfer',$request->isTransfer)
                ->get();

            $jumlah = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->where('isTransfer',$request->isTransfer)
                ->groupBy('bulan_bayar')
                ->selectRaw('monthname(bulan_bayar) as bulan, sum(jumlah) as jumlah')
                ->get(['jumlah','bulan']);

            $total = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->where('isTransfer',$request->isTransfer)
                ->selectRaw('sum(jumlah) as jumlah')
                ->value('jumlah');
        }
        elseif($request->pendapatanLain){
            $pendapatans = Pendapatan::whereNotNull('jenis_pendapatan_id')
                ->whereYear('created_at',Carbon::today()->year)->get();

            $jumlah = Pendapatan::whereNotNull('jenis_pendapatan_id')
                ->whereYear('created_at',Carbon::today()->year)
                ->groupBy('bulan_bayar')
                ->selectRaw('monthname(bulan_bayar) as bulan, sum(jumlah) as jumlah')
                ->get(['jumlah','bulan']);

            $total = Pendapatan::whereNotNull('jenis_pendapatan_id')
                ->whereYear('created_at',Carbon::today()->year)
                ->selectRaw('sum(jumlah) as jumlah')
                ->value('jumlah');
        }
        else{
            $pendapatans = Pendapatan::whereYear('created_at',Carbon::today()->year)->get();

            $jumlah = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->groupBy('bulan_bayar')
                ->selectRaw('monthname(bulan_bayar) as bulan, sum(jumlah) as jumlah')
                ->get(['jumlah','bulan']);

            $total = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->selectRaw('sum(jumlah) as jumlah')
                ->value('jumlah');
        
        }
    
        return view('pendapatan.index',compact(['pendapatans','jumlah','total']));
    }

    public function create()
    {
        $jenis_pendapatans = JenisPendapatan::all();
        return view('pendapatan.create',compact('jenis_pendapatans'));
    }

    public function store(Request $request)
    {
        // dd($request->jenis_pendapatan);
        $jumlah = str_replace(',', '', $request->jumlah);

        $pend = $request->validate([
            'bulan_bayar' => 'required',
            'keterangan' => 'required',
            'isTransfer' => 'required',
            'jumlah' => 'required',
        ]);

        Pendapatan::create([
            'bulan_bayar' => Carbon::parse($request->bulan_bayar.'-01')->format('Y-m-d'),
            'keterangan' => $request->keterangan,
            'isTransfer' => $request->isTransfer,
            'jenis_pendapatan_id' => $request->jenis_pendapatan,
            'jumlah' => $jumlah,
        ]);

        return redirect('pendapatan')
            ->with('status','success')
            ->with('message','Data berhasil diinput');
    }

    public function show(Pendapatan $pendapatan)
    {
        //
    }

    public function edit(Pendapatan $pendapatan)
    {
        //
    }

    public function update(Request $request, Pendapatan $pendapatan)
    {
        //
    }

    public function destroy(Pendapatan $pendapatan)
    {
        $pendapatan->delete();
        return redirect('/pendapatan')
            ->with('status','success')
            ->with('message','Data berhasil dihapus');
    }

    public function import(){
        set_time_limit(0);
        $users = Excel::toCollection(new KodeDistribusiImport, request()->file('file'));
        //  dd($users[0]);
        foreach($users[0] as $row){
            if($row['jan']!==null){
                if($row['jan']!==0){
                    $bayar = $row['jan'];
                    $user = Pendapatan::create([
                        'bulan_bayar'=>'2022-01-01',
                        'keterangan'=>$row['ket'],
                        'isTransfer'=>false,
                        'jumlah'=>$bayar,
                    ]);
                }
            }

            if($row['feb_cash'] !== null){
                $bayar = $row['feb_cash'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-02-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>false,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            elseif($row['feb_trf'] !== null){
                $bayar = $row['feb_trf'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-02-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>true,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            if($row['mar_cash'] !== null){
                $bayar = $row['mar_cash'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-03-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>false,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            elseif($row['mar_trf'] !== null){
                $bayar = $row['mar_trf'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-03-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>true,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            if($row['apr_cash'] !== null){
                $bayar = $row['apr_cash'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-04-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>false,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            elseif($row['apr_trf'] !== null){
                $bayar = $row['apr_trf'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-04-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>true,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            if($row['mei_cash'] !== null){
                $bayar = $row['mei_cash'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-05-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>false,
                            'jumlah'=>$bayar,
                        ]);
                
            }
            elseif($row['mei_trf'] !== null){
                $bayar = $row['mei_trf'];
                $user = Pendapatan::create([
                            'bulan_bayar'=>'2022-05-01',
                            'keterangan'=>$row['ket'],
                            'isTransfer'=>true,
                            'jumlah'=>$bayar,
                        ]);
                
            }
        }
        //     $user = Pendapatan::create([
        //                 'bulan_bayar'=>'2022-07-06',
        //                 'keterangan'=>$row['ket'],
        //                 'isTransfer'=>false,
        //                 'jenis_pendapatan_id' => $row['jenis'],
        //                 'jumlah'=>$row['jumlah'],
        //             ]);
        // }
        
        return redirect('pendapatan')->with('success', 'All good!');
    }

    public function cetak(Request $request)
    {set_time_limit(0);
        $jenis_pendapatans = JenisPendapatan::all();
        if ($request->pendapatanLain){
            $pendapatans = Pendapatan::whereYear('created_at',Carbon::today()->year)
                ->whereNotNull('jenis_pendapatan_id')
                ->get();

        }else{
            $pendapatans = Pendapatan::whereYear('created_at',Carbon::today()->year)->get();
        }
        
        // $months = getMonthsYear();
        // //array 1
        // $pend = []; $array = [];
        // foreach($pendapatans as $key => $pendapatan){
        //     //array 2
           

        //     $pend['id'] = $pendapatan->id;

        //     //array 3
        //     $bayar = collect();
        //     $bayar->put('isTransfer',$pendapatan->isTransfer);
        //     $bayar->put('biaya',$pendapatan->biaya);

        //     //masukkan array 3 ke array 2
        //     $array[$pendapatan->created_at->format('M')] = $bayar;
            
        // }
        // foreach ($months as $key => $month){
        //     // cek bulan, jika tidak ada maka isinya null
        //     if(array_key_exists($month,$pend) == false){
        //         $pend[$month] = null;
        //     }
        // }
//masukkan array 2 ke array 1
            // $pend['bulan'] = $array;
        // $months = getMonthsYear();
        // $cols = [];
        // foreach($pendapatans as $key => $pendapatan){
        //     $array = [];
        //     $array['pendapatan_id'] = $pendapatan->id;
        //     foreach ($pendapatan->pembayaran as $pembayaran) {
        //         $bulan = [];
        //         $total = 0;
        //         foreach ($pembayaran->detailPembayaran as $detail) {
        //             $bayar = collect();
        //             $bayar->put('isTransfer',$pembayaran->isTransfer);
        //             $bayar->put('biaya',$detail->biaya);
        //             $total += $detail->biaya;
        //             $bulan[Carbon::parse($detail->bulan_bayar)->format('M')] = $bayar;
        //             $array['pembayaran'] = $bulan;
        //             $array['total'] = $total;
        //         }
        //         foreach ($months as $key => $month){
        //             if(array_key_exists($month,$bulan) == false){
        //                 $bayars = collect();
        //                 $bayars->put('isTransfer',null);
        //                 $bayars->put('biaya',null);
        //                 $bulan[$month] = $bayars;
        //                 $array['pembayaran'] = $bulan;
        //             }
        //         }
                
        //     }
        //     array_push($cols,$array);
        // }

        // foreach($cols as $key => $col){
        //     if (array_key_exists('pembayaran',$cols[$key]) == false) {
        //         $cols[$key]['pembayaran'] = null;
        //         $cols[$key]['total'] = 0;
        //     }
        // }

        return view('pendapatan.cetak',compact(['pendapatans','jenis_pendapatans']));
    }
}
