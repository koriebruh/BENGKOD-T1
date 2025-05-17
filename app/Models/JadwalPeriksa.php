<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $table = 'jadwal_periksa';

    public $timestamps = false;
    protected $fillable = [
        'id_dokter',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kuota_max',
        'kuota_terpakai',
        'status',
    ];

    // Relasi ke User (dokter)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
}
