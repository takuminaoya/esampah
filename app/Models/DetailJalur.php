<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJalur extends Model
{
    use HasFactory;

    protected $fillable = [
        'jalur_id',
        'banjar_id'
    ];

    public function jalur(){
        return $this->belongsTo(Jalur::class, 'jalur_id');
    }

    public function banjar(){
        return $this->belongsTo(Banjar::class, 'banjar_id');
    }
}
