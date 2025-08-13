<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'status'
    ];

    public function detailJalur(){
        return $this->hasMany(DetailJalur::class, 'jalur_id');
    }
}
