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
            <a href="{{ route('dokter.memeriksa') }}" class="nav-link active">
                <i class="nav-icon fas fa-stethoscope"></i>
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
            <a href="{{ route('dokter.historyPeriksa') }}" class="nav-link">
                <i class="nav-icon fas fa-history"></i>
                <p>History Periksa</p>
            </a>
        </li>
    </ul>
@endsection

@section('title', 'Memeriksa Pasien')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Memeriksa Pasien</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dokter.memeriksa') }}">Memeriksa</a></li>
                            <li class="breadcrumb-item active">Form Pemeriksaan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <!-- Patient Information Card -->
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-injured"></i> Informasi Pasien
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><i class="fas fa-user mr-2"></i>Nama Pasien</label>
                                    <p class="form-control-static font-weight-bold">{{ $janjiPeriksa->pasien->name }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-envelope mr-2"></i>Email</label>
                                    <p class="form-control-static">{{ $janjiPeriksa->pasien->email }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-id-card mr-2"></i>No. KTP</label>
                                    <p class="form-control-static">{{ $janjiPeriksa->pasien->no_ktp ?? 'Tidak tersedia' }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-phone mr-2"></i>No. HP</label>
                                    <p class="form-control-static">{{ $janjiPeriksa->pasien->no_hp ?? 'Tidak tersedia' }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-map-marker-alt mr-2"></i>Alamat</label>
                                    <p class="form-control-static">{{ $janjiPeriksa->pasien->alamat ?? 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Appointment Information Card -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-check"></i> Informasi Janji
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt mr-2"></i>Hari</label>
                                    <p class="form-control-static font-weight-bold">{{ ucfirst($janjiPeriksa->jadwalPeriksa->hari) }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-clock mr-2"></i>Waktu</label>
                                    <p class="form-control-static">{{ $janjiPeriksa->jadwalPeriksa->jam_mulai }} - {{ $janjiPeriksa->jadwalPeriksa->jam_selesai }}</p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-sort-numeric-up mr-2"></i>No. Antrian</label>
                                    <p class="form-control-static">
                                        <span class="badge badge-primary badge-lg">{{ $janjiPeriksa->no_antrian }}</span>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-notes-medical mr-2"></i>Keluhan</label>
                                    <div class="alert alert-light">
                                        {{ $janjiPeriksa->keluhan ?? 'Tidak ada keluhan' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Examination Form -->
                    <div class="col-md-8">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-stethoscope"></i> Form Pemeriksaan
                                </h3>
                            </div>
                            <form action="{{ route('dokter.memeriksaPasien', $janjiPeriksa->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <!-- Tanggal Periksa -->
                                    <div class="form-group">
                                        <label for="tgl_periksa">
                                            <i class="fas fa-calendar-alt mr-2"></i>Tanggal Periksa
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="datetime-local"
                                               class="form-control @error('tgl_periksa') is-invalid @enderror"
                                               id="tgl_periksa"
                                               name="tgl_periksa"
                                               value="{{ old('tgl_periksa', now()->format('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('tgl_periksa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Catatan -->
                                    <div class="form-group">
                                        <label for="catatan">
                                            <i class="fas fa-sticky-note mr-2"></i>Catatan Pemeriksaan
                                        </label>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror"
                                                  id="catatan"
                                                  name="catatan"
                                                  rows="4"
                                                  placeholder="Masukkan catatan hasil pemeriksaan...">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Obat -->
                                    <div class="form-group">
                                        <label for="obat">
                                            <i class="fas fa-pills mr-2"></i>Pilih Obat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 @error('obat') is-invalid @enderror"
                                                id="obat"
                                                name="obat[]"
                                                multiple="multiple"
                                                data-placeholder="Pilih obat yang akan diberikan"
                                                required>
                                            @foreach($obatList as $obat)
                                                <option value="{{ $obat->id }}"
                                                        data-harga="{{ $obat->harga }}"
                                                    {{ in_array($obat->id, old('obat', [])) ? 'selected' : '' }}>
                                                    {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Biaya Estimasi -->
                                    <div class="form-group">
                                        <label>
                                            <i class="fas fa-money-bill-wave mr-2"></i>Estimasi Biaya
                                        </label>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <span>Biaya Konsultasi:</span><br>
                                                        <span>Biaya Obat:</span><br>
                                                        <hr>
                                                        <strong>Total Biaya:</strong>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <span>Rp 150.000</span><br>
                                                        <span id="total-obat">Rp 0</span><br>
                                                        <hr>
                                                        <strong id="total-biaya">Rp 150.000</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="{{ route('dokter.memeriksa') }}" class="btn btn-secondary btn-block">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-success btn-block" id="submit-btn">
                                                <i class="fas fa-save"></i> Simpan Pemeriksaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Calculate total cost when medicines are selected
            $('#obat').on('change', function() {
                let totalObat = 0;
                let selectedOptions = $(this).find('option:selected');

                selectedOptions.each(function() {
                    totalObat += parseInt($(this).data('harga')) || 0;
                });

                let biayaKonsultasi = 150000;
                let totalBiaya = biayaKonsultasi + totalObat;

                $('#total-obat').text('Rp ' + totalObat.toLocaleString('id-ID'));
                $('#total-biaya').text('Rp ' + totalBiaya.toLocaleString('id-ID'));

                // Enable/disable submit button based on selection
                if (selectedOptions.length > 0) {
                    $('#submit-btn').prop('disabled', false);
                } else {
                    $('#submit-btn').prop('disabled', true);
                }
            });

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Form validation
            $('form').on('submit', function(e) {
                let selectedObat = $('#obat').val();
                if (!selectedObat || selectedObat.length === 0) {
                    e.preventDefault();
                    alert('Harap pilih minimal satu obat untuk pasien.');
                    return false;
                }
            });

            // Initialize the form
            $('#obat').trigger('change');
        });
    </script>

    <style>
        .select2-container--bootstrap4 .select2-selection {
            height: calc(2.25rem + 2px) !important;
        }

        .form-control-static {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
            margin-bottom: 0;
            border: 0;
        }

        .badge-lg {
            font-size: 1.1em;
            padding: 0.5rem 1rem;
        }
    </style>
@endsection
