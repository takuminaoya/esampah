<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pegawai_id',
        'status',
        'verifikasi_bendahara',
        'total',
        'isTransfer',
        'jumlah_bulan',
        'bukti_bayar',
        'tanggal_bayar'
    ];
    
    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailPembayaran(){
        return $this->hasMany(DetailPembayaran::class, 'pembayaran_id');
    }

}
