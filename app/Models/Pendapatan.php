<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan_bayar',
        'keterangan',
        'isTransfer',
        'jumlah',
        'jenis_pendapatan_id',
        'pembayaran_id'
    ];

    public function jenisPendapatan(){
        return $this->belongsTo(JenisPendapatan::class, 'jenis_pendapatan_id');
    }
}
