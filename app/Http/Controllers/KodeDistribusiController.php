<?php

namespace App\Http\Controllers;

use App\Imports\KodeDistribusiImport;
use App\Imports\UsersImport;
use App\Models\KodeDistribusi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function GuzzleHttp\Promise\all;

class KodeDistribusiController extends Controller
{
    
    public function index()
    {
        $distribusis = KodeDistribusi::all();
        return view('kode-distribusi.index',compact('distribusis'));
    }

    public function getKodeDistribusi(){
        $distribusis = KodeDistribusi::all();
        return response()->json($distribusis);
    }

    public function create()
    {
        return view('kode-distribusi.create');
    }

    public function store(Request $request)
    {
        $kode = $request->validate([
            'objek' => 'required',
            'kode' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required',
        ]);

        KodeDistribusi::create($kode);

        return redirect('kode-distribusi')
            ->with('status','success')
            ->with('message','Data berhasil diinput');
    }

    public function show(KodeDistribusi $kodeDistribusi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KodeDistribusi  $kodeDistribusi
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeDistribusi $kodeDistribusi)
    {
        return view('kode-distribusi.edit',compact('kodeDistribusi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KodeDistribusi  $kodeDistribusi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KodeDistribusi $kodeDistribusi)
    {
        
        $edit = $request->validate([
            'objek' => 'required',
            'kode'  => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|min:1'    
        ]);

        $kodeDistribusi->update($edit);

        return redirect('kode-distribusi')
            ->with('status','success')
            ->with('message','Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KodeDistribusi  $kodeDistribusi
     * @return \Illuminate\Http\Response
     */
    public function destroy(KodeDistribusi $kodeDistribusi)
    {
        $kodeDistribusi->delete();

        return redirect('kode-distribusi')
            ->with('status','success')
            ->with('message','Data berhasil dihapus');
    }
}
