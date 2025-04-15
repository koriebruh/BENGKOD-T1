<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{

    use HasFactory;

    protected $table = "periksas";

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

    public function obat()
    {
        return $this->belongsToMany(Obat::class, 'detail_periksas', 'id_periksa', 'id_obat');
    }

    public static function getPeriksaByDokterId($dokterId)
    {
        return self::where('id_dokter', $dokterId)
            ->with(['dokter', 'pasien'])  // Eager load the 'dokter' and 'pasien' relations
            ->get();
    }
}
