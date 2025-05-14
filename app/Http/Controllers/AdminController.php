<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $totalObat = Obat::count();
        $totalPeriksa = Periksa::where('id_dokter', auth()->user()->id)->count();
        $totalDokter =User::where('role', 'dokter')->count();
        $totalPelangan =User::where('role', 'pasien')->count();

        return view('admin.dashboard', compact('totalObat', 'totalPeriksa','totalDokter','totalPelangan'));
    }

    /*CRUD OBAT DEKKK
     * */
    public function showObat()
    {
        try {
            $obat = Obat::all();
            return view('admin.obatMaster', compact('obat'));
        } catch (\Exception $e) {
            Log::error("Error fetching obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data obat.');
        }
    }

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

            return redirect()->route('admin.obatMaster')->with('success', 'Obat berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error("Error creating obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan obat.');
        }
    }

    public function editObat($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            return view('admin.obatEdit', compact('obat'));
        } catch (\Exception $e) {
            Log::error("Error fetching obat for edit: " . $e->getMessage());
            return redirect()->back()->with('error', 'Obat tidak ditemukan.');
        }
    }

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

            return redirect()->route('admin.obatMaster')->with('success', 'Obat berhasil diupdate');
        } catch (\Exception $e) {
            Log::error("Error updating obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui obat.');
        }
    }

    public function deleteObat($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

            return redirect()->route('admin.obatMaster')->with('success', 'Obat berhasil dihapus');
        } catch (\Exception $e) {
            Log::error("Error deleting obat: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus obat.');
        }
    }

    /*CRUD DOKTER Dekkkk
     * */

    public function showUsers($role)
    {
        try {
            // Pastikan role adalah string
            if (is_object($role) && property_exists($role, 'name')) {
                $roleName = $role->name;
            } else {
                $roleName = $role;
            }

            // Fetch users based on the provided role
            $users = User::where('role', $roleName)->get();

            if ($roleName == 'dokter') {
                return view('admin.dokterMaster', compact('users'));
            } elseif ($roleName == 'pasien') {
                return view('admin.pasienMaster', compact('users'));
            } else {
                return view('admin.userMaster', compact('users'));
            }
        } catch (\Exception $e) {
            Log::error("Error fetching users: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data pengguna.');
        }
    }

    public function createUser(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'alamat' => 'nullable|string',
                'no_hp' => 'nullable|string',
                'role' => 'required|string', // Adjust roles as necessary
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'alamat' => $validatedData['alamat'] ?? null,
                'no_hp' => $validatedData['no_hp'] ?? null,
                'role' => $validatedData['role'],  //
            ]);

            if ($validatedData['role'] == 'pasien') {
                return redirect()->route('admin.pasienMaster')->with('success', 'User successfully created.');
            } elseif ($validatedData['role'] == 'dokter') {
                return redirect()->route('admin.dokterMaster')->with('success', 'User successfully created.');
            } else{
                Log::error("Error creating user: ");
                return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pengguna role salah.');
            }

        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pengguna.');
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Return different views based on user role
            if ($user->role == 'dokter') {
                return view('admin.dokterEdit', compact('user'));
            } elseif ($user->role == 'pasien') {
                return view('admin.pasienEdit', compact('user'));
            } else {
                return view('admin.userEdit', compact('user'));
            }
        } catch (\Exception $e) {
            Log::error("Error fetching user for edit: " . $e->getMessage());
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'alamat' => 'nullable|string',
                'no_hp' => 'nullable|string',
                'role' => 'required|string',
            ]);

            // If password is provided, validate it
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'string|min:8|confirmed',
                ]);
            }

            $user = User::findOrFail($id);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->alamat = $validatedData['alamat'] ?? $user->alamat;
            $user->no_hp = $validatedData['no_hp'] ?? $user->no_hp;
            $user->role = $validatedData['role'];

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            // Redirect based on user role
            if ($user->role == 'pasien') {
                return redirect()->route('admin.pasienMaster')->with('success', 'Data pasien berhasil diperbarui.');
            } elseif ($user->role == 'dokter') {
                return redirect()->route('admin.dokterMaster')->with('success', 'Data dokter berhasil diperbarui.');
            } else {
                return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui.');
            }
        } catch (\Exception $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data pengguna.');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $userRole = $user->role; // Save role before deletion for redirect
            $user->delete();

            // Redirect based on deleted user's role
            if ($userRole == 'pasien') {
                return redirect()->route('admin.pasienMaster')->with('success', 'Data pasien berhasil dihapus.');
            } elseif ($userRole == 'dokter') {
                return redirect()->route('admin.dokterMaster')->with('success', 'Data dokter berhasil dihapus.');
            } else {
                return redirect()->back()->with('success', 'Data pengguna berhasil dihapus.');
            }
        } catch (\Exception $e) {
            Log::error("Error deleting user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengguna.');
        }
    }


}
