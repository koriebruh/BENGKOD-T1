<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function showRiwayat()
    {
        $id_pasien = auth()->user()->id;

        $periksas = Periksa::with(['pasien', 'dokter', 'obat'])
            ->where('id_pasien', $id_pasien)
            ->get();

        return view('pasien.riwayat', compact('periksas'));
    }

//    public function pasientDashboard()
//    {
//
//
//    }


}
