<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function periksa()
    {
        // Get the ID of the currently logged-in doctor
        $id_dokter = auth()->user()->id;

        // Fetch only the examinations associated with this doctor
        $periksas = Periksa::with(['pasien', 'dokter','obat'])
            ->where('id_dokter', $id_dokter)
            ->get();

        return view('dokter.periksa', compact('periksas'));
    }

    public function editPeriksa($id)
    {
        // Ambil data pemeriksaan berdasarkan ID
        $periksa = Periksa::with(['pasien', 'dokter', 'obat'])->findOrFail($id);

        // Pastikan dokter yang login hanya bisa mengedit pemeriksaan miliknya
        if ($periksa->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.periksa')->with('error', 'Unauthorized access.');
        }

        // Ambil daftar obat untuk dropdown
        $obatList = Obat::all();

        // Ambil daftar pasien untuk dropdown
        $pasienList = User::where('role', 'pasien')->get();

        // Tampilkan halaman edit dengan data pemeriksaan, daftar obat, dan daftar pasien
        return view('dokter.editPeriksa', compact('periksa', 'pasienList', 'obatList'));
    }

    public function updatePeriksa(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_pasien' => 'required|exists:users,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|numeric',
            'obat' => 'required|array',  // Memastikan obat dipilih
            'obat.*' => 'exists:obats,id',  // Memastikan setiap obat yang dipilih ada di database
        ]);

        // Ambil data pemeriksaan
        $periksa = Periksa::findOrFail($id);

        // Pastikan dokter yang login hanya bisa mengedit pemeriksaan miliknya
        if ($periksa->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.periksa')->with('error', 'Unauthorized access.');
        }

        // Update data pemeriksaan
        $periksa->update([
            'id_pasien' => $request->id_pasien,
            'tgl_periksa' => $request->tgl_periksa,
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa,
        ]);

        // Menyimpan relasi obat yang dipilih
        $periksa->obat()->sync($request->obat);

        return redirect()->route('dokter.periksa')->with('success', 'Pemeriksaan berhasil diperbarui.');
    }



    public function deletePeriksa($id)
    {
        // Get the examination to delete
        $periksa = Periksa::findOrFail($id);

        // Ensure the doctor is authorized to delete the examination
        if ($periksa->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.periksa')->with('error', 'Unauthorized access.');
        }

        // Delete the examination
        $periksa->delete();

        return redirect()->route('dokter.periksa')->with('success', 'Examination deleted successfully.');
    }

    public function dokterDashboard()
    {
        $totalObat = Obat::count();
        $totalPeriksa = Periksa::where('id_dokter', auth()->user()->id)->count();
        $totalDokter =User::where('role', 'dokter')->count();
        $totalPelangan =User::where('role', 'pasien')->count();

        return view('dokter.dashboard', compact('totalObat', 'totalPeriksa','totalDokter','totalPelangan'));
    }

}


/////////dss
