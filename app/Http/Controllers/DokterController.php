<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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


    /*SELF EDIT
     * */
    public function getProfile($id)
    {

        $user = User::findOrFail($id);

        // Check if the logged-in user is the same as the one being edited
        if ($user->id !== Auth::id()) {
            return redirect()->route('dokter.dashboard')->with('error', 'Unauthorized access.');
        }

        return view('dokter.dashboardEdit', compact('user'));
    }

    public function editProfile(Request $request){
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update basic information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->alamat = $validated['alamat'];
        $user->no_hp = $validated['no_hp'];

        // Update password if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }

            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('dokter.dashboard')->with('success', 'Profile updated successfully!');
    }

    /*JADWAL
     * */

    //NEMAMPILKAN SEMUA JADWAL DOKTER TERSEBUT
    public function dokterJadwal(){
        if (Auth::user()->role !== 'dokter') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('dokter.jadwalPeriksa', compact('jadwalPeriksa'));
    }


    //MENERRIMA INPUT UNUTK DI SIMPAN
    public function storeJadwal(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_dokter' => 'required|exists:users,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota_max' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,penuh,tidak_aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek jadwal bentrok untuk dokter yang sama
        $existingJadwal = JadwalPeriksa::where('id_dokter', $request->id_dokter)
            ->where('tanggal', $request->tanggal)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($existingJadwal) {
            return redirect()->back()
                ->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada.'])
                ->withInput();
        }

        // Buat jadwal baru
        JadwalPeriksa::create([
            'id_dokter' => $request->id_dokter,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kuota_max' => $request->kuota_max,
            'kuota_terpakai' => 0, // Default 0 karena jadwal baru
            'status' => $request->status,
        ]);

        return redirect()->route('dokter.jadwalPeriksa')
            ->with('success', 'Jadwal periksa berhasil dibuat.');

    }


    //INI GET DATA JADWAL UNUTK FORM
    public function editJadwal($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        // Pastikan dokter yang login hanya bisa mengedit jadwal miliknya
        if ($jadwal->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Unauthorized access.');
        }

        return view('dokter.jadwalPeriksaEdit', compact('jadwal'));
    }


    public function updateJadwal()
    {
        // Validasi input
        $validator = Validator::make(request()->all(), [
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota_max' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,penuh,tidak_aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update jadwal
        $jadwal = JadwalPeriksa::findOrFail(request('id'));

        // Pastikan dokter yang login hanya bisa mengedit jadwal miliknya
        if ($jadwal->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Unauthorized access.');
        }

        $jadwal->update(request()->all());

        return redirect()->route('dokter.jadwalPeriksa')
            ->with('success', 'Jadwal periksa berhasil diperbarui.');
    }

    public function deleteJadwal($id)
    {
        // Get the jadwal to delete
        $jadwal = JadwalPeriksa::findOrFail($id);

        // Ensure the doctor is authorized to delete the jadwal
        if ($jadwal->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Unauthorized access.');
        }

        // Delete the jadwal
        $jadwal->delete();

        return redirect()->route('dokter.jadwalPeriksa')->with('success', 'Jadwal deleted successfully.');
    }

}

