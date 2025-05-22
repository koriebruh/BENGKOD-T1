@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.obatMaster') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                ObatMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.dokterMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> DokterMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.pasienMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> PasienMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.poliMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-user-injured"></i> PoliMaster</a></li>
    </ul>
@endsection


@section('content')
    <div class="container mt-4">
        <h1 class="display-4 text-primary">Edit Obat</h1>

        <!-- Tampilkan pesan error -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Edit Obat -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Form Edit Obat</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/obat/update/' . $obat->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_obat">Nama Obat</label>
                        <input type="text" name="nama_obat" id="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kemasan">Kemasan</label>
                        <input type="text" name="kemasan" id="kemasan" class="form-control" value="{{ $obat->kemasan }}" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="{{ $obat->harga }}" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('admin.obatMaster') }}" class="btn btn-secondary ml-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
