<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = "obat";

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga'
    ];

    public function getHargaAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

}
