<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'kode_pelanggan',
        'kode_rekanan',
        'password',
        'nik',
        'alamat',
        'telp',
        'banjar_id',
        'usaha',
        'verified',
        'kode_distribusi_id',
        'biaya',
        'tgl_verified',
        'rekanan_id',
        'tenggat_bayar',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function getOrderNoAttribute() {
        return str_pad($this->kode_rekanan,4,'0',STR_PAD_LEFT);
    }

    public function pengambilan(){
        return $this->hasMany(Pengambilan::class, 'user_id');
    }

    public function statusPelanggan(){
        return $this->hasMany(StatusPelanggan::class, 'user_id');
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'user_id');
    }

    public function banjar(){
        return $this->belongsTo(Banjar::class, 'banjar_id');
    }

    public function distributionCode(){
        return $this->belongsTo(KodeDistribusi::class, 'kode_distribusi_id');
    }

    public function rekanan(){
        return $this->belongsTo(Rekanan::class, 'rekanan_id');
    }

    public function detailPembayaran(){
        return $this->hasMany(DetailPembayaran::class, 'pembayaran_id');
    }

}
