<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'nik',
        'alamat',
        'telp',
        'banjar_id',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pengambilan(){
        return $this->hasMany(Pengambilan::class, 'pegawai_id');
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'pegawai_id');
    }
    public function banjar(){
        return $this->belongsTo(Banjar::class, 'banjar_id');
    }
}
