@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.obat') }}" class="nav-link"> <i class="nav-icon fas fa-th"></i>
                Obat</a></li>
        <li class="nav-item"><a href="{{ route('dokter.periksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Periksa</a></li>
    </ul>
@endsection


@section('content')
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="display-4 text-primary">Daftar Obat</h1>
                <p class="lead text-muted">Kelola obat-obat yang tersedia di klinik Anda dengan mudah dan efisien.</p>
            </div>
        </div>

        <!-- Form Tambah Obat -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Tambah Obat</h5>
            </div>
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
                    <button type="submit" class="btn btn-primary btn-block">Tambah Obat</button>
                </form>
            </div>
        </div>

        <!-- Tampilkan pesan sukses atau error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Tabel Obat -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Daftar Obat yang Tersedia</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
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
                            <td>Rp {{ number_format((float) $item->harga, 2, ',', '.') }}</td>
                            <td>
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
        </div>
    </div>

    <!-- Add the following script to hide the alerts after 2 seconds -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(function () {
                const successAlert = document.getElementById("alert-success");
                const errorAlert = document.getElementById("alert-error");

                if (successAlert) {
                    successAlert.classList.add("fade");
                    successAlert.classList.remove("show");
                }
                if (errorAlert) {
                    errorAlert.classList.add("fade");
                    errorAlert.classList.remove("show");
                }
            }, 2000);
        });
    </script>
@endsection
