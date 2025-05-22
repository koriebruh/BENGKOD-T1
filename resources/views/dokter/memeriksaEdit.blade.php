@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.memeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Periksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.jadwalPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> JadwalPeriksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.historyPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> historyPeriksa</a></li>
    </ul>
@endsection



@section('title', 'Edit Pemeriksaan Pasien')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Pemeriksaan Pasien</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dokter.memeriksa') }}">Memeriksa</a></li>
                            <li class="breadcrumb-item active">Edit Pemeriksaan</li>
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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan dalam form:
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <!-- Patient Info Card -->
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-injured"></i> Informasi Pasien
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <div class="profile-img-container">
                                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                                    </div>
                                </div>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Nama:</strong></td>
                                        <td>{{ $periksa->pasien->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $periksa->pasien->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dokter:</strong></td>
                                        <td>{{ $periksa->dokter->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Menunggu Pemeriksaan
                                        </span>
                                        </td>
                                    </tr>
                                </table>
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
                            <form action="{{ route('dokter.memeriksaPasien', $periksa->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <!-- Pasien Selection -->
                                    <div class="form-group">
                                        <label for="id_pasien">
                                            <i class="fas fa-user-injured text-primary"></i> Pasien
                                        </label>
                                        <select class="form-control select2 @error('id_pasien') is-invalid @enderror"
                                                id="id_pasien"
                                                name="id_pasien"
                                                required>
                                            <option value="">Pilih Pasien</option>
                                            @foreach($pasienList as $pasien)
                                                <option value="{{ $pasien->id }}"
                                                    {{ old('id_pasien', $periksa->id_pasien) == $pasien->id ? 'selected' : '' }}>
                                                    {{ $pasien->name }} - {{ $pasien->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Examination Date -->
                                    <div class="form-group">
                                        <label for="tgl_periksa">
                                            <i class="fas fa-calendar-alt text-info"></i> Tanggal Periksa
                                        </label>
                                        <input type="date"
                                               class="form-control @error('tgl_periksa') is-invalid @enderror"
                                               id="tgl_periksa"
                                               name="tgl_periksa"
                                               value="{{ old('tgl_periksa', $periksa->tgl_periksa) }}"
                                               required>
                                        @error('tgl_periksa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="form-group">
                                        <label for="catatan">
                                            <i class="fas fa-notes-medical text-warning"></i> Catatan Pemeriksaan
                                        </label>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror"
                                                  id="catatan"
                                                  name="catatan"
                                                  rows="4"
                                                  placeholder="Masukkan catatan pemeriksaan, keluhan pasien, diagnosa, dll...">{{ old('catatan', $periksa->catatan) }}</textarea>
                                        @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Medicine Selection -->
                                    <div class="form-group">
                                        <label for="obat">
                                            <i class="fas fa-pills text-success"></i> Obat yang Diberikan
                                        </label>
                                        <select class="form-control select2 @error('obat') is-invalid @enderror"
                                                id="obat"
                                                name="obat[]"
                                                multiple="multiple"
                                                data-placeholder="Pilih obat yang akan diberikan"
                                                required>
                                            @foreach($obatList as $obat)
                                                <option value="{{ $obat->id }}"
                                                        data-price="{{ $obat->harga }}"
                                                    {{ in_array($obat->id, old('obat', $periksa->obat->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                    {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Pilih satu atau lebih obat yang akan diberikan kepada pasien
                                        </small>
                                    </div>

                                    <!-- Cost Calculation Display -->
                                    <div class="form-group">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <i class="fas fa-calculator text-primary"></i> Rincian Biaya
                                                </h6>
                                                <table class="table table-sm mb-0">
                                                    <tr>
                                                        <td>Biaya Konsultasi Dokter:</td>
                                                        <td class="text-right"><strong>Rp 150.000</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Harga Obat:</td>
                                                        <td class="text-right">
                                                            <span id="totalObat"><strong>Rp 0</strong></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="table-primary">
                                                        <td><strong>Total Biaya Periksa:</strong></td>
                                                        <td class="text-right">
                                                            <span id="totalBiaya"><strong>Rp 150.000</strong></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('dokter.memeriksa') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-success">
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
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Calculate total cost when medicine selection changes
            function calculateTotal() {
                let totalObat = 0;
                const selectedOptions = $('#obat option:selected');

                selectedOptions.each(function() {
                    const price = parseInt($(this).data('price')) || 0;
                    totalObat += price;
                });

                const biayaKonsultasi = 150000;
                const totalBiaya = totalObat + biayaKonsultasi;

                $('#totalObat').html('<strong>Rp ' + new Intl.NumberFormat('id-ID').format(totalObat) + '</strong>');
                $('#totalBiaya').html('<strong>Rp ' + new Intl.NumberFormat('id-ID').format(totalBiaya) + '</strong>');
            }

            // Calculate initial total
            calculateTotal();

            // Recalculate when medicine selection changes
            $('#obat').on('change', function() {
                calculateTotal();
            });

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Form validation
            $('form').on('submit', function(e) {
                const selectedObat = $('#obat').val();
                if (!selectedObat || selectedObat.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Silakan pilih minimal satu obat untuk pasien.',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
