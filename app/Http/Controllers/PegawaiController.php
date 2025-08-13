<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petugass = Pegawai::where('level','petugas')->get();
        return view('petugas.index',compact('petugass'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $token = env('TOKEN_API');
        $url = 'https://desaungasan.badungkab.go.id/api/banjar?token='.$token;
        $response = Http::get($url);
        $datas = $response->object();
        $banjars = $datas->data;
        return view('petugas.create',compact('banjars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $petugas = $request->validate([
            '*' => 'required'
        ]);

        Pegawai::create($petugas);

        return redirect('petugas')
            ->with('status','success')
            ->with('message','Data berhasil diinput');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        //
    }

    public function updateStatus(Pegawai $pegawai)
    {
       
        if($pegawai->status == true){
            Pegawai::where('id',$pegawai->id)->update(['status' => false]);
        }else{
            Pegawai::where('id',$pegawai->id)->update(['status' => true]);
        }
        return redirect()->back()
            ->with('status','success')
            ->with('message','Status pelanggan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        //
    }
}
