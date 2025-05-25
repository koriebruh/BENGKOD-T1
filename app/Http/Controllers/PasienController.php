<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
    public function showRiwayat()
    {
        $id_pasien = auth()->user()->id;

        $periksas = Periksa::with(['pasien', 'obat','janjiPeriksa.jadwalPeriksa.dokter'])
            ->where('id_pasien', $id_pasien)
            ->get();

//        dd($periksas->first()->janjiPeriksa->jadwalPeriksa->dokter ?? 'Relasi tidak ada');

        return view('pasien.riwayat', compact('periksas'));
    }

//    public function showPolis()
//    {
//        $polis = Poli::all();
//        return view('pasien.janjiPeriksa', compact('polis'));
//    }

    public function createJanjiPeriksa(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_pasien' => 'required|exists:users,id',
                'id_jadwal_periksa' => 'required|exists:jadwal_periksa,id',
                'keluhan' => 'required|string|max:500',
            ]);

            // Generate nomor antrian otomatis
            $lastAntrian = JanjiPeriksa::where('id_jadwal_periksa', $validatedData['id_jadwal_periksa'])
                ->max('no_antrian');
            $noAntrian = $lastAntrian ? $lastAntrian + 1 : 1;

            // Cek apakah pasien sudah memiliki janji pada jadwal yang sama
            $existingJanji = JanjiPeriksa::where('id_pasien', $validatedData['id_pasien'])
                ->where('id_jadwal_periksa', $validatedData['id_jadwal_periksa'])
                ->first();
            if ($existingJanji) {
                return redirect()->back()->with('error', 'Pasien sudah memiliki janji pada jadwal yang sama.');
            }

            $validatedData['no_antrian'] = $noAntrian;
            JanjiPeriksa::create($validatedData);

            return redirect()->route('pasien.janjiPeriksa')->with('success', 'Janji Periksa berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error("Error creating janji periksa: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat janji periksa.');
        }
    }

    public function showJanjiPeriksaPasien(Request $request)
    {
        $id_pasien = auth()->user()->id;

        // Ambil riwayat janji periksa yang belum ada di tabel periksas (belum diperiksa)
        $janjiPeriksas = JanjiPeriksa::with(['jadwalPeriksa.dokter.poli', 'pasien'])
            ->where('id_pasien', $id_pasien)
            ->whereDoesntHave('periksa')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar poli untuk form
        $polis = Poli::all();

        // Jika ada parameter poli_id, ambil jadwal untuk poli tersebut
        $jadwalPeriksas = collect();
        if ($request->has('poli_id') && $request->poli_id) {
            $jadwalPeriksas = JadwalPeriksa::with(['dokter.poli'])
                ->whereHas('dokter', function($query) use ($request) {
                    $query->where('poli_id', $request->poli_id);
                })
                ->where('status', true)
                ->orderBy('hari', 'asc')
                ->orderBy('jam_mulai', 'asc')
                ->get();
        }

        return view('pasien.janjiPeriksa', compact('janjiPeriksas', 'polis', 'jadwalPeriksas'));
    }

// Method ini bisa dihapus atau dijadikan API endpoint saja
    public function jadwalOpenByPoli($id)
    {
        $jadwalPeriksas = JadwalPeriksa::with(['dokter.poli'])
            ->whereHas('dokter', function($query) use ($id) {
                $query->where('poli_id', $id);
            })
            ->where('status', true)
            ->orderBy('hari', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return response()->json(['jadwalPeriksas' => $jadwalPeriksas]);
    }

    public function pasienDashboard()
    {
        $totalPeriksa = Periksa::where('id_pasien', auth()->user()->id)->count();
        $totalSpending = Periksa::where('id_pasien', auth()->user()->id)->where('biaya_periksa', '>', 0)->count();

        return view('pasien.dashboard', compact('totalPeriksa', 'totalSpending'));
    }


}
