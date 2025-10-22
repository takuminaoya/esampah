<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembuangan extends Model
{
    use HasFactory;
    protected $table = 'rekap_pembuangans';
    protected $fillable = [
        'tanggal',
        'kendaraan_id',
        'jumlah',
    ];

    public function kendaraan(){
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
