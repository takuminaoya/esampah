<?php

namespace App\Models\Ungasan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $connection = "ungasan";
    protected $primaryKey = "sid";
    protected $table = "penduduks";
}
