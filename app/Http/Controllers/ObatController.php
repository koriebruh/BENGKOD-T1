<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//CRUD
class ObatController
{
    public function __construct()
    {
        // Menambahkan middleware auth untuk semua method
        $this->middleware('auth');

        // Menambahkan middleware khusus untuk memeriksa role dokter
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role != 'dokter') {
                abort(403, 'Unauthorized action. Only doctors can access this page.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $obats = Obat::all();
        return view('pages.master_obat', compact('obats'));
    }

    public function create()
    {
        return view('dokter.obat.create');
    }

    public function store(Request $request)
    {
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('dokter.obat.index');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('dokter.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('dokter.obat.index')->with('status', 'Obat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('dokter.obat.index')->with('status', 'Obat berhasil dihapus!');
    }
}
