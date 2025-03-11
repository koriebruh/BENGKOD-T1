<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periksa;

class PeriksaController
{
    public function __construct()
    {
        //MAKE SURE USER IS DOKTER
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'dokter') {
                return redirect('/home');
            }
            return $next($request);
        });
    }

    // Menampilkan form untuk pemeriksaan pasien
    public function create($id_pasien)
    {
        $obats = Obat::all(); // Mengambil semua obat
        return view('dokter.create_periksa', compact('id_pasien', 'obats'));
    }

    // Menyimpan hasil pemeriksaan pasien
    public function store(Request $request, $id_pasien)
    {
        // Menyimpan pemeriksaan pasien
        $periksa = Periksa::create([
            'id_pasien' => $id_pasien,
            'id_dokter' => Auth::user()->id, // ID dokter yang login
            'tgl_periksa' => now(),
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa,
        ]);

        // Menyimpan detail pemeriksaan (obat yang dipilih)
        foreach ($request->obat_id as $obat_id) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obat_id,
            ]);
        }

        return redirect()->route('dokter.periksa.show', $periksa->id);
    }

    // SHOW RESULT PEMERIKSAAN BY ID PASIEN
    public function show($id)
    {
        $periksa = Periksa::with('detailPeriksa.obat')->findOrFail($id);
        return view('dokter.show_periksa', compact('periksa'));
    }

}
