<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function notYetPeriksa()
    {
        // Get the ID of the currently logged-in doctor
        $id_dokter = auth()->user()->id;

        // Fetch only the examinations associated with this doctor
        $periksas = Periksa::with(['pasien', 'dokter', 'obat'])
            ->where('id_dokter', $id_dokter)
            ->where('biaya_periksa', "<=", 0)
            ->get();

        return view('dokter.memeriksa', compact('periksas'));
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
        return view('dokter.memeriksaEdit', compact('periksa', 'pasienList', 'obatList'));
    }

    public function memeriksaPasien(Request $request, $id)
    {

        $request->validate([
            'id_pasien' => 'required|exists:users,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string',
            'obat' => 'required|array',  // Memastikan obat dipilih
            'obat.*' => 'exists:obats,id',  // Memastikan setiap obat yang dipilih ada di database
        ]);


        $periksa = Periksa::findOrFail($id);

        // Pastikan dokter yang login hanya bisa mengedit pemeriksaan miliknya
        if ($periksa->id_dokter !== auth()->user()->id) {
            return redirect()->route('dokter.periksa')->with('error', 'Unauthorized access.');
        }

        // Menghitung total harga obat yang dipilih
        $totalHargaObat = Obat::whereIn('id', $request->obat)->sum('harga');

        // Hitung biaya pemeriksaan dengan menambahkan 150k ke total harga obat
        $biayaPeriksa = $totalHargaObat + 150000;

        // Update data pemeriksaan
        $periksa->update([
            'id_pasien' => $request->id_pasien,
            'tgl_periksa' => $request->tgl_periksa,
            'catatan' => $request->catatan,
            'biaya_periksa' => $biayaPeriksa, // Update biaya pemeriksaan dengan harga yang dihitung
        ]);

        // Menyimpan relasi obat yang dipilih
        $periksa->obat()->sync($request->obat);

        return redirect()->route('dokter.memeriksa')->with('success', 'Pemeriksaan berhasil diperbarui.');
    }


    public function deletePeriksa($id)
    {
        // Get the examination to delete
        $periksa = Periksa::findOrFail($id);

        // Ensure the doctor is authorized to delete the examination
        if ($periksa->id_dokter !== auth()->user()->id) {
            Log::error("Error delete periksa: ", $id);
            return redirect()->route('dokter.memeriksa')->with('error', 'Unauthorized access.');
        }

        // Delete the examination
        $periksa->delete();
        Log::error("Error delete periksa: ", $id);

        return redirect()->route('dokter.memeriksa')->with('success', 'Examination deleted successfully.');
    }

    public function dokterDashboard()
    {
//        $totalPeriksa = Periksa::where('id_dokter', auth()->user()->id)->count();
//        $totalBelumDiPeriksa = JanjiPeriksa::Where('id_jadwal_periksa', '!=', null)
//            ->whereHas('jadwalPeriksa', function ($query) {
//                $query->where('id_dokter', auth()->user()->id);
//            })->count();


        $totalPeriksa =  1;
        $totalBelumDiPeriksa = JanjiPeriksa::Where('id_jadwal_periksa', '!=', null)
            ->whereHas('jadwalPeriksa', function ($query) {
                $query->where('id_dokter', auth()->user()->id);
            })->count();



        return view('dokter.dashboard', compact('totalPeriksa', 'totalBelumDiPeriksa',));
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

    public function editProfile(Request $request)
    {
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

    //MENAMPILKAN SEMUA JADWAL DOKTER TERSEBUT
    public function dokterJadwal()
    {
        if (Auth::user()->role !== 'dokter') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $hariOptions = [
            'senin' => 'senin',
            'selasa' => 'selasa',
            'rabu' => 'rabu',
            'kamis' => 'kamis',
            'jumat' => 'jumat'
        ];

        // Mendapatkan jadwal yang sedang aktif
        $activeSchedule = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('status', 1)
            ->first();

        return view('dokter.jadwalPeriksa', compact('jadwalPeriksa', 'hariOptions', 'activeSchedule'));
    }

    //MENERIMA INPUT UNTUK DISIMPAN
    public function storeJadwal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', Rule::in(['senin', 'selasa', 'rabu', 'kamis', 'jumat'])],
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek bentrok jadwal pada hari yang sama
        $bentrok = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrok) {
            return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada pada hari yang sama.'])->withInput();
        }

        // Jika status aktif, nonaktifkan semua jadwal lain
        if ($request->status == 1) {
            JadwalPeriksa::where('id_dokter', Auth::id())
                ->where('status', 1)
                ->update(['status' => 0]);
        }

        // Simpan jadwal
        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
        ]);

        $message = 'Jadwal periksa berhasil ditambahkan.';
        if ($request->status == 1) {
            $message .= ' Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
        }

        return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);
    }

    //GET DATA JADWAL UNTUK FORM EDIT
    public function editJadwal($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        if ($jadwal->id_dokter !== auth()->id()) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
        }

        // Mendapatkan jadwal yang sedang aktif (selain jadwal yang sedang diedit)
        $activeSchedule = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('status', 1)
            ->where('id', '!=', $id)
            ->first();

        return view('dokter.jadwalPeriksaEdit', compact('jadwal', 'activeSchedule'));
    }

    //UPDATE JADWAL
    public function updateJadwal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', Rule::in(['senin', 'selasa', 'rabu', 'kamis', 'jumat'])],
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Check authorization
            if ($jadwal->id_dokter !== auth()->id()) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            // Check for schedule conflicts (exclude current schedule) pada hari yang sama
            $bentrok = JadwalPeriksa::where('id_dokter', Auth::id())
                ->where('hari', $request->hari)
                ->where('id', '!=', $id) // Exclude current schedule
                ->where(function ($query) use ($request) {
                    $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })
                ->exists();

            if ($bentrok) {
                return redirect()->back()->withErrors(['jadwal' => 'Jadwal bentrok dengan jadwal yang sudah ada pada hari yang sama.'])->withInput();
            }

            // Jika status diubah menjadi aktif, nonaktifkan semua jadwal lain
            $wasActive = $jadwal->status == 1;
            $willBeActive = $request->status == 1;

            if ($willBeActive && !$wasActive) {
                // Jadwal ini akan diaktifkan, nonaktifkan yang lain
                JadwalPeriksa::where('id_dokter', Auth::id())
                    ->where('id', '!=', $id)
                    ->where('status', 1)
                    ->update(['status' => 0]);
            }

            // Update the schedule
            $jadwal->update([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
            ]);

            $message = 'Jadwal berhasil diperbarui.';
            if ($willBeActive && !$wasActive) {
                $message .= ' Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal.')->withInput();
        }
    }

    //HAPUS JADWAL
    public function deleteJadwal($id)
    {
        try {
            // Get the jadwal to delete
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Ensure the doctor is authorized to delete the jadwal
            if ($jadwal->id_dokter !== auth()->user()->id) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            // Cek apakah jadwal yang akan dihapus sedang aktif
            $isActiveSchedule = $jadwal->status == 1;

            // Delete the jadwal
            $jadwal->delete();

            $message = 'Jadwal berhasil dihapus.';
            if ($isActiveSchedule) {
                $message .= ' Tidak ada jadwal aktif saat ini, silakan aktifkan jadwal lain jika diperlukan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }

    //FUNGSI UNTUK TOGGLE STATUS JADWAL (OPSIONAL - untuk kemudahan penggunaan)
    public function toggleStatusJadwal($id)
    {
        try {
            $jadwal = JadwalPeriksa::findOrFail($id);

            // Check authorization
            if ($jadwal->id_dokter !== auth()->id()) {
                return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Akses tidak diizinkan.');
            }

            if ($jadwal->status == 0) {
                // Jika akan diaktifkan, nonaktifkan jadwal lain terlebih dahulu
                JadwalPeriksa::where('id_dokter', Auth::id())
                    ->where('id', '!=', $id)
                    ->where('status', 1)
                    ->update(['status' => 0]);

                // Aktifkan jadwal ini
                $jadwal->update(['status' => 1]);
                $message = 'Jadwal berhasil diaktifkan. Jadwal lain yang sebelumnya aktif telah dinonaktifkan.';
            } else {
                // Nonaktifkan jadwal ini
                $jadwal->update(['status' => 0]);
                $message = 'Jadwal berhasil dinonaktifkan.';
            }

            return redirect()->route('dokter.jadwalPeriksa')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('dokter.jadwalPeriksa')->with('error', 'Terjadi kesalahan saat mengubah status jadwal.');
        }
    }

    /*HISTORY PERIKSA BY DOKTER
     * */

    public function showHitoryPemeriksaan()
    {
        // Get the ID of the currently logged-in doctor
        $id_dokter = auth()->user()->id;

        // Fetch only the examinations associated with this doctor
        $periksas = Periksa::with(['pasien', 'dokter', 'obat'])
            ->where('id_dokter', $id_dokter)
            ->where('biaya_periksa', ">", 0)
            ->get();


        return view('dokter.historyPeriksa', compact('periksas'));
    }


}

