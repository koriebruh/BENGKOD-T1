<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => "email can not nil",
            'password.required' => "password can not nil"
        ]);

        //QUERY DB, VALIDATION PASS AND GET ROLE
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            //SET SESSION
            Auth::login($user);

            // Mengirimkan nama pengguna untuk ditampilkan pada view setelah login
            $username = Auth::user()->name;

            if ($user->role === 'dokter') {
                return redirect()->intended('/dokter/dashboard')->with($username);
            } elseif ($user->role === 'pasien') {
                return redirect()->intended('/pasien/dashboard')->with($username);
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with($username);
            }else {
                return redirect()->intended('/login');
            }

        } else {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'no_ktp' => 'nullable|string|unique:users',
            // Validasi lainnya
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'pasien',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'no_ktp' => $request->no_ktp,
        ]);

        Auth::login($user);

        return redirect('/login');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
