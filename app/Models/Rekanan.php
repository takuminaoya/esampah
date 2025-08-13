<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'telp',
    ];

    public function user(){
        return $this->hasMany(User::class, 'rekanan_id');
    }

    public function kendaraan(){
        return $this->hasMany(Kendaraan::class, 'rekanan_id');
    }
}
