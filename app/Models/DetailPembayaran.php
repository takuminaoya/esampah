<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembayaran_id',
        'bulan_bayar',
        'biaya',
        'user_id'
    ];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
