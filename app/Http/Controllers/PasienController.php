<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
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


    public function createPeriksa(Request $request)
    {

        $validatedData = $request->validate([
            'id_dokter' => 'required|exists:users,id',
            'tgl_periksa' => 'required|date',
        ]);

        $periksa = new Periksa();
        $periksa->id_pasien = auth()->user()->id;
        $periksa->id_dokter = $validatedData['id_dokter'];
        $periksa->tgl_periksa = $validatedData['tgl_periksa'];
        $periksa->biaya_periksa = 0; // Set biaya_periksa menjadi 0 jika tidak ada inputan dari form
        $periksa->save();

        return redirect()->route('pasien.riwayat')->with('success', 'Periksa berhasil dibuat.');
    }

    public function showPeriksaForm()
    {
        $dokters = User::where('role', 'dokter')->get(); // Sesuaikan dengan role dokter
        return view('pasien.periksa', compact('dokters'));
    }

    public function pasienDashboard()
    {
        $totalPeriksa = Periksa::where('id_pasien', auth()->user()->id)->count();
        $totalSpending =Periksa::where('id_pasien', auth()->user()->id)->where('biaya_periksa', '>', 0)->count();

        return view('pasien.dashboard', compact('totalPeriksa', 'totalSpending',));
    }

}
