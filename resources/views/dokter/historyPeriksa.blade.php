@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item">
            <a href="{{ route('dokter.dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dokter.memeriksa') }}" class="nav-link">
                <i class="nav-icon fas fa-user-md"></i>
                <p>Memeriksa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dokter.jadwalPeriksa') }}" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Jadwal Periksa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dokter.historyPeriksa') }}" class="nav-link active">
                <i class="nav-icon fas fa-history"></i>
                <p>History Periksa</p>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">History Periksa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">History Periksa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Pemeriksaan Pasien</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if($periksas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Keluhan</th>
                                            <th>Catatan Dokter</th>
                                            <th>Obat</th>
                                            <th>BiayaTotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($periksas as $index => $periksa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ $periksa->pasien->name }}</strong>
                                                </td>
                                                <td>
                                                        <span class="badge badge-info">
                                                            {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y H:i') }}
                                                        </span>
                                                </td>
                                                <td>
                                                    {{ $periksa->janjiPeriksa->keluhan ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $periksa->catatan ?? '-' }}
                                                </td>
                                                <td>
                                                    @if($periksa->obat->count() > 0)
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach($periksa->obat as $obat)
                                                                <li class="mb-1">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                            <span class="badge badge-secondary">
                                                                                {{ $obat->nama_obat }} ({{ $obat->kemasan }})
                                                                            </span>
                                                                        <small class="text-success font-weight-bold">
                                                                            Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                                                        </small>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong class="text-success">
                                                        Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada riwayat pemeriksaan</h5>
                                    <p class="text-muted">Data pemeriksaan akan muncul setelah Anda melakukan pemeriksaan pasien.</p>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        @if(method_exists($periksas, 'hasPages') && $periksas->hasPages())
                            <div class="card-footer">
                                {{ $periksas->links() }}
                            </div>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable if you want to add search/sort functionality
            // $('.table').DataTable({
            //     "responsive": true,
            //     "lengthChange": false,
            //     "autoWidth": false,
            // });
        });
    </script>
@endpush


