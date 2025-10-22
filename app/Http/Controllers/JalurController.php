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
        $banjars = Banjar::all();
        return view('jalur.create', compact('banjars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'banjar_ids' => 'required|array',
            'banjar_ids.*' => 'exists:banjars,id'
        ]);

        // Create new jalur
        $jalur = Jalur::create([
            'nama' => $request->nama,
            'status' => true
        ]);

        // Create detail jalur with the correct order
        foreach($request->banjar_ids as $banjar_id) {
            DetailJalur::create([
                'jalur_id' => $jalur->id,
                'banjar_id' => $banjar_id
            ]);
        }

        return redirect('jalur')
            ->with('status', 'success')
            ->with('message', 'Jalur berhasil ditambahkan');
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
        $details = DetailJalur::where('jalur_id', $jalur->id)->orderBy('id', 'asc')->get();
        $banjars = Banjar::all();
        return view('jalur.edit', compact(['jalur', 'details', 'banjars']));
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
            'nama' => 'required|string|max:255',
            'banjar_ids' => 'required|array'
        ]);

        // Update jalur name
        $jalur->update([
            'nama' => $request->nama
        ]);

        // Delete all existing detail jalur
        $jalur->detailJalur()->delete();

        // Create new detail jalur with the correct order
        foreach($request->banjar_ids as $index => $banjar_id) {
            DetailJalur::create([
                'jalur_id' => $jalur->id,
                'banjar_id' => $banjar_id
            ]);
        }

        return redirect('jalur')
            ->with('status', 'success')
            ->with('message', 'Jalur berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jalur  $jalur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jalur $jalur)
    {
        try {
            // Delete all detail jalur records first
            $jalur->detailJalur()->delete();
            
            // Delete the jalur
            $jalur->delete();
            
            return redirect('jalur')
                ->with('status', 'success')
                ->with('message', 'Jalur berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('jalur')
                ->with('status', 'error')
                ->with('message', 'Gagal menghapus jalur: ' . $e->getMessage());
        }
    }
}
