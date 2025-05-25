@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('pasien.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('pasien.janjiPeriksa') }}" class="nav-link active"> <i
                    class="nav-icon fas fa-th"></i>
                Janji Periksa</a></li>
        <li class="nav-item"><a href="{{ route('pasien.riwayat') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Riwayat Periksa</a></li>
    </ul>
@endsection

@section('title', 'Janji Periksa')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Janji Periksa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Janji Periksa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Form Buat Janji Periksa -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Janji Periksa
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Step 1: Pilih Poli -->
                        @if(!request('poli_id'))
                            <form action="{{ route('pasien.janjiPeriksa') }}" method="GET">
                                <div class="form-group">
                                    <label for="poli_id">
                                        <i class="fas fa-hospital mr-1"></i>
                                        Pilih Poli
                                    </label>
                                    <select class="form-control select2" id="poli_id" name="poli_id" required>
                                        <option value="">-- Pilih Poli --</option>
                                        @foreach($polis as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fas fa-search mr-2"></i>
                                    Lihat Jadwal Poli
                                </button>
                            </form>
                        @else
                            <!-- Step 2: Pilih Jadwal dan Buat Janji -->
                            <form action="{{ route('pasien.createJanjiPeriksa') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pasien" value="{{ auth()->user()->id }}">

                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-hospital mr-1"></i>
                                        Poli Terpilih
                                    </label>
                                    <div class="form-control-plaintext">
                                        <span class="badge badge-info badge-lg">
                                            {{ $polis->where('id', request('poli_id'))->first()->nama_poli }}
                                        </span>
                                        <a href="{{ route('pasien.janjiPeriksa') }}" class="btn btn-sm btn-outline-secondary ml-2">
                                            <i class="fas fa-edit"></i> Ganti Poli
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="id_jadwal_periksa">
                                        <i class="fas fa-calendar mr-1"></i>
                                        Pilih Jadwal
                                    </label>
                                    @if(isset($jadwalPeriksas) && $jadwalPeriksas->count() > 0)
                                        <select class="form-control select2" id="id_jadwal_periksa" name="id_jadwal_periksa" required>
                                            <option value="">-- Pilih Jadwal --</option>
                                            @foreach($jadwalPeriksas as $jadwal)
                                                <option value="{{ $jadwal->id }}" {{ old('id_jadwal_periksa') == $jadwal->id ? 'selected' : '' }}>
                                                    Dr. {{ $jadwal->dokter->nama }} - {{ $jadwal->hari }}
                                                    ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Tidak ada jadwal tersedia untuk poli ini.
                                        </div>
                                    @endif
                                </div>

                                @if(isset($jadwalPeriksas) && $jadwalPeriksas->count() > 0)
                                    <div class="form-group">
                                        <label for="keluhan">
                                            <i class="fas fa-comment-medical mr-1"></i>
                                            Keluhan
                                        </label>
                                        <textarea class="form-control" id="keluhan" name="keluhan" rows="4"
                                                  placeholder="Jelaskan keluhan Anda..." maxlength="500" required>{{ old('keluhan') }}</textarea>
                                        <small class="form-text text-muted">
                                            <span id="keluhanCount">{{ strlen(old('keluhan')) }}</span>/500 karakter
                                        </small>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save mr-2"></i>
                                        Buat Janji Periksa
                                    </button>
                                @endif
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Info Jadwal (jika ada) -->
                @if(request('poli_id') && isset($jadwalPeriksas) && $jadwalPeriksas->count() > 0)
                    <div class="card card-info mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>
                                Jadwal Tersedia
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Dokter</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jadwalPeriksas as $jadwal)
                                        <tr>
                                            <td>
                                                <small><strong>Dr. {{ $jadwal->dokter->nama }}</strong></small>
                                            </td>
                                            <td>
                                                <small>{{ $jadwal->hari }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Daftar Janji Periksa -->
            <div class="col-md-8">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list mr-2"></i>
                            Daftar Janji Periksa Saya
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($janjiPeriksas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="janjiPeriksaTable">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Poli</th>
                                        <th width="20%">Dokter</th>
                                        <th width="15%">Hari</th>
                                        <th width="15%">Jam</th>
                                        <th width="10%">No. Antrian</th>
                                        <th width="20%">Keluhan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($janjiPeriksas as $index => $janji)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                    <span class="badge badge-info">
                                                        {{ $janji->jadwalPeriksa->dokter->poli->nama_poli }}
                                                    </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-md text-primary mr-2"></i>
                                                    <div>
                                                        <strong>{{ $janji->jadwalPeriksa->dokter->nama }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar-day text-success mr-1"></i>
                                                {{ $janji->jadwalPeriksa->hari }}
                                            </td>
                                            <td>
                                                <i class="fas fa-clock text-warning mr-1"></i>
                                                {{ $janji->jadwalPeriksa->jam_mulai }} - {{ $janji->jadwalPeriksa->jam_selesai }}
                                            </td>
                                            <td class="text-center">
                                                    <span class="badge badge-success badge-lg">
                                                        {{ $janji->no_antrian }}
                                                    </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ Str::limit($janji->keluhan, 50, '...') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Janji Periksa</h5>
                                <p class="text-muted">Anda belum memiliki janji periksa yang aktif. Silakan buat janji periksa baru.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Initialize DataTable
            $('#janjiPeriksaTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });

            // Character counter for keluhan
            $('#keluhan').on('input', function() {
                const maxLength = 500;
                const currentLength = $(this).val().length;
                $('#keluhanCount').text(currentLength);

                if (currentLength > maxLength * 0.9) {
                    $('#keluhanCount').addClass('text-warning');
                } else {
                    $('#keluhanCount').removeClass('text-warning');
                }
            });
        });
    </script>
@stop
