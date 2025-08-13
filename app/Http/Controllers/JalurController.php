<?php

namespace App\Http\Controllers;

use App\Models\Banjar;
use App\Models\DetailJalur;
use App\Models\Jalur;
use Illuminate\Http\Request;

class JalurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = DetailJalur::all();
        $jalurs = Jalur::all();
        $banjars = Banjar::all();
        return view('jalur.index',compact(['jalurs','details','banjars']));
    }

    public function postUpdateStatus(Jalur $jalur){
        if ($jalur->status == true){
            $jalur->update(['status' => false]);
        }else{
            $jalur->update(['status' => true]);
        }

        return redirect('jalur')
            ->with('status','success')
            ->with('message','Status berhasil diubah');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jalur  $jalur
     * @return \Illuminate\Http\Response
     */
    public function show(Jalur $jalur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jalur  $jalur
     * @return \Illuminate\Http\Response
     */
    public function edit(Jalur $jalur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jalur  $jalur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jalur $jalur)
    {
        $request->validate([
            'banjars' => 'required'
        ]);
        $jalurs_old = DetailJalur::where('jalur_id',$jalur->id)->get();

        foreach($jalurs_old as $jalur_old){
            DetailJalur::where('jalur_id',$jalur_old->id)->delete();
        }

        foreach($request->banjars as $banjar){
             DetailJalur::create([
                'jalur_id' => $jalur->id,
                'banjar_id' => $banjar
             ]);
        }

        return redirect('jalur')
            ->with('status','success')
            ->with('message','Jalur berhasil diubah');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jalur  $jalur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jalur $jalur)
    {
        //
    }
}
