<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPendapatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama'
    ];

    public function pendapatan(){
        return $this->hasMany(Pendapatan::class, 'jenis_pendapatan_id');
    }
}
