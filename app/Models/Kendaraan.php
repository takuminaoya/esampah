<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat',
        'rekanan_id',
    ];

    public function rekanan(){
        return $this->belongsTo(Rekanan::class, 'rekanan_id');
    }
}

