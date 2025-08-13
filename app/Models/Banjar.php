<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banjar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function detailJalur(){
        return $this->hasMany(DetailJalur::class, 'banjar_id');
    }
    
    public function user(){
        return $this->hasMany(User::class, 'banjar_id');
    }

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'banjar_id');
    }
}
