<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeDistribusi extends Model
{
    use HasFactory;

    protected $fillable = [
        'objek',
        'kode',
        'kategori',
        'jumlah',
    ];

    public function user(){
        return $this->hasMany(KodeDistribusi::class, 'kode_distribusi_id');
    }

}
