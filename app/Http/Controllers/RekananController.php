<?php

namespace App\Http\Controllers;

use App\Models\Rekanan;
use App\Models\User;
use Illuminate\Http\Request;

class RekananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekanans = Rekanan::all();
        return view('rekanan.index',compact(['rekanans']));
    }

    public function detail(Rekanan $rekanan)
    {
        $pelanggans = User::where('verified',true)->where('status',true)->where('rekanan_id',$rekanan->id)->get();
        return view('rekanan.detail',compact(['pelanggans']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Models\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function show(Rekanan $rekanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Rekanan $rekanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekanan $rekanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekanan $rekanan)
    {
        //
    }
}
