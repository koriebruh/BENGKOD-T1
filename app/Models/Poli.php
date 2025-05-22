<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    //define nama tabel
    protected $table = "poli";

    protected $fillable = [
        'nama_poli',
        'keterangan',
    ];
}
