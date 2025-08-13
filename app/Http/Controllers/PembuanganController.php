<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pembuangan;
use App\Models\Rekanan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PembuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembuangans = Pembuangan::whereYear('tanggal',Carbon::today()->year)->get();
        $total = Pembuangan::whereYear('tanggal',Carbon::today()->year)
            ->whereMonth('tanggal',Carbon::today()->month)
            ->groupBy('kendaraan_id')
            ->selectRaw('kendaraan_id, sum(jumlah) as jumlah, sum(jumlah)*100000 as total')
            ->orderBy('kendaraan_id')
            ->get(['total','kendaraan_id', 'jumlah']);
        //dd($total);
        $kendaraans = Kendaraan::all();
   
        return view('pembuangan.index',compact(['pembuangans','kendaraans', 'total']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kendaraans = Kendaraan::all();
        return view('pembuangan.create',compact('kendaraans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembuangan = $request->validate([
            'tanggal' => 'required',
            'kendaraan_id' => 'required',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Pembuangan::create($pembuangan);

        return redirect('pembuangan')
            ->with('status','success')
            ->with('message','Data berhasil diinput');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembuangan  $pembuangan
     * @return \Illuminate\Http\Response
     */
    public function show(Pembuangan $pembuangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembuangan  $pembuangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembuangan $pembuangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembuangan  $pembuangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembuangan $pembuangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembuangan  $pembuangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembuangan $pembuangan)
    {
        $pembuangan->delete();

        return redirect('pembuangan')
            ->with('status','success')
            ->with('message','Data berhasil dihapus');
    }

    public function cetak(){
        $id_rekanan = Kendaraan::pluck('rekanan_id')->unique();
        $kendaraans = Kendaraan::orderBy('rekanan_id','ASC')->get();
        $rekanans = Rekanan::whereIn('id',$id_rekanan)->orderBy('id','ASC')->get(['id','nama']);
        $pembuangans = Pembuangan::whereYear('tanggal',Carbon::today()->year)->whereMonth('tanggal',Carbon::today()->month)->get();

        $total = Pembuangan::whereYear('tanggal',Carbon::today()->year)
            ->whereMonth('tanggal',Carbon::today()->month)
            ->groupBy('kendaraan_id')
            ->selectRaw('kendaraan_id, sum(jumlah) as jumlah, sum(jumlah)*100000 as total')
            ->orderBy('kendaraan_id')
            ->get(['total','kendaraan_id', 'jumlah']);
    //dd($total);
         $kendaraans = Kendaraan::all();
        //$pembuangans = Pembuangan::whereYear('tanggal',Carbon::today()->year)->get(['id','tanggal','jumlah','kendaraan_id'])->toarray();
//         dd($pembuangans);
//         $array = [];
//         // foreach($kendaraans as $kendaraan){
//         //     foreach($pembuangans as $pembuangan){
//         //         // if ($pembuangan->kendaraan_)
//         //     }
//         // }
//         $array2 = [];
//         $interval = CarbonPeriod::create('2022-01-01','2022-02-01');
//         foreach ($interval as $date){
//             foreach($pembuangans as $pembuangan){
//                 $tanggal = $date->format('d');
//                 if(Carbon::parse($pembuangan->tanggal)->format('d') == $date->format('d')){
//                     foreach($kendaraans as $kendaraan){
//                         if($kendaraan->id == $pembuangan->kendaraan_id){
//                             $array[$pembuangan->kendaraan->plat] = $pembuangan->jumlah;
//                             array_push($array2[$tanggal],$array);
//                         }
//                     }
                    
//                 }
//                 // if($pembuangan->jumlah == )
//         }
// }
        
        return view('pembuangan.cetak',compact(['rekanans','kendaraans','id_rekanan','pembuangans','kendaraans', 'total']));
    }
}
