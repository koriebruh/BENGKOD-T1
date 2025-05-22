@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.obatMaster') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                ObatMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.dokterMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-user-md"></i> DokterMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.pasienMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-user-injured"></i> PasienMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.poliMaster') }}" class="nav-link active"><i
                    class="nav-icon fas fa-hospital"></i> PoliMaster</a></li>
    </ul>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Poli</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data Poli</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add New Poli Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Poli Baru</h3>
                </div>
                <form method="POST" action="{{ route('admin.createPolis') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_poli">Nama Poli</label>
                                    <input type="text" class="form-control @error('nama_poli') is-invalid @enderror"
                                           id="nama_poli" name="nama_poli" value="{{ old('nama_poli') }}"
                                           placeholder="Masukkan nama poli" required>
                                    @error('nama_poli')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                              id="keterangan" name="keterangan" rows="3"
                                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Data Table Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Poli</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="poliTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="25%">Nama Poli</th>
                                <th width="40%">Keterangan</th>
                                <th width="15%">Tanggal Dibuat</th>
                                <th width="15%">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($poli as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->nama_poli }}</strong>
                                    </td>
                                    <td>
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.editPoli', $item->id) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.deletePoli', $item->id) }}"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus poli {{ $item->nama_poli }}?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data poli</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function () {
            $("#poliTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                "info": true,
                "paging": true,
                "searching": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                },
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#poliTable_wrapper .col-md-6:eq(0)');

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection
