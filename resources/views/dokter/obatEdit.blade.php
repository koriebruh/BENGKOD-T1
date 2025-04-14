@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.obat') }}" class="nav-link">Obat</a></li>
    </ul>
@endsection

@section('content')
    <div class="container mt-4">
        <h1>Edit Obat</h1>

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
        <form action="{{ url('dokter/obat/update/' . $obat->id) }}" method="POST">
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
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('dokter.obat') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
