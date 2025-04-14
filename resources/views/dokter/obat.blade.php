@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.obat') }}" class="nav-link">Obat</a></li>
    </ul>
@endsection

@section('content')
    <div class="container mt-4">
        <h1>Daftar Obat</h1>

        <!-- Form Tambah Obat -->
        <div class="card mb-4">
            <div class="card-header">Tambah Obat</div>
            <div class="card-body">
                <form action="{{ url('dokter/obat') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_obat">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="kemasan">Kemasan</label>
                        <input type="text" name="kemasan" id="kemasan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Obat</button>
                </form>
            </div>
        </div>

        <!-- Tampilkan pesan sukses atau error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel Obat -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kemasan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($obat as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama_obat }}</td>
                    <td>{{ $item->kemasan }}</td>
                    <td>Rp {{ number_format((float) $item->harga, 2, ',', '.') }}</td>                    <td>
                        <a href="{{ url('dokter/obat/edit/' . $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ url('dokter/obat/delete/' . $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus obat ini?')">Hapus</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data obat</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
