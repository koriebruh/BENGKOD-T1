<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiPeriksa extends Model
{
    protected $table = 'janji_periksas';

    //REQUIRED FILED
    protected $fillable = [
        'id_pasien',
        'id_jadwal_periksa',
        'keluhan',
        'no_antrian',
    ];


    public function jadwalPeriksa()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal_periksa');
    }


    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');  // asumsikan 'id_janji_periksa' adalah kolom yang menghubungkan kedua tabel
    }

}
