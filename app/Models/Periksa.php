<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{

    use HasFactory;

    protected $table = "periksa";

    protected $fillable = [
        'id_pasien',
        'id_dokter',
        'tgl_periksa',
        'catatan',
        'biaya_periksa'
    ];

    //RELATION TO USER
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    //RELATION TO USER
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function getTglPeriksaAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y H:i');
    }

}
