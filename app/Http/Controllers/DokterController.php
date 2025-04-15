<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    // Show all obat
    public function showObat()
    {
        try {
            $obat = Obat::all();
            return view('dokter.obat', compact('obat'));
        } catch (\Exception $e) {
            Log::error("Error fetching obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data obat.');
        }
    }

    // Create new obat
    public function createObat(Request $request)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'nama_obat' => 'required|string|max:255',
                'kemasan' => 'required|string|max:255',
                'harga' => 'required|numeric|min:1',
            ]);

            // Create new obat and save
            $obat = new Obat();
            $obat->nama_obat = $request->input('nama_obat');
            $obat->kemasan = $request->input('kemasan');
            $obat->harga = $request->input('harga');
            $obat->save();

            return redirect()->route('dokter.obat')->with('success', 'Obat berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error("Error creating obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan obat.');
        }
    }

    // Update existing obat
    public function editObat($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            return view('dokter.obatEdit', compact('obat'));
        } catch (\Exception $e) {
            Log::error("Error fetching obat for edit: " . $e->getMessage());
            return redirect()->back()->with('error', 'Obat tidak ditemukan.');
        }
    }

    // Save updated obat
    public function updateObat(Request $request, $id)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'nama_obat' => 'required|string|max:255',
                'kemasan' => 'required|string|max:255',
                'harga' => 'required|numeric|min:1',
            ]);

            $obat = Obat::findOrFail($id);
            $obat->nama_obat = $request->input('nama_obat');
            $obat->kemasan = $request->input('kemasan');
            $obat->harga = $request->input('harga');
            $obat->save();

            return redirect()->route('dokter.obat')->with('success', 'Obat berhasil diupdate');
        } catch (\Exception $e) {
            Log::error("Error updating obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui obat.');
        }
    }

    // Delete obat
    public function deleteObat($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

            return redirect()->route('dokter.obat')->with('success', 'Obat berhasil dihapus');
        } catch (\Exception $e) {
            Log::error("Error deleting obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus obat.');
        }
    }

    public function periksa()
    {
        // Get the ID of the currently logged-in doctor
        $id_dokter = auth()->user()->id;

        // Fetch only the examinations associated with this doctor
        $periksas = Periksa::with(['pasien', 'dokter'])
            ->where('id_dokter', $id_dokter)
            ->get();

        return view('dokter.periksa', compact('periksas'));
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
