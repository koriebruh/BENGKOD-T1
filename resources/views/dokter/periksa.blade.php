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
        <h1 class="display-4 text-primary">Daftar Pemeriksaan {{ Auth::user()->name }}</h1>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Tanggal Periksa</th>
                <th>Catatan</th>
                <th>Biaya Periksa</th>
            </tr>
            </thead>
            <tbody>
            @foreach($periksas as $periksa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $periksa->pasien->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $periksa->dokter->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $periksa->tgl_periksa }}</td>
                    <td>{{ $periksa->catatan }}</td>
                    <td>{{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
