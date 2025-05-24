@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('pasien.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('pasien.janjiPeriksa') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                Janji Periksa</a></li>
        <li class="nav-item"><a href="{{ route('pasien.riwayat') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Riwayat Periksa</a></li>
    </ul>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Form Janji Periksa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('pasien.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pasien.janjiPeriksa') }}">Janji Periksa</a></li>
                            <li class="breadcrumb-item active">Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-plus"></i> Buat Janji Periksa
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('pasien.janjiPeriksa') }}" class="btn btn-tool">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>

                            <form action="{{ route('pasien.createJanjiPeriksa') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pasien" value="{{ auth()->user()->id }}">

                                <div class="card-body">
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

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <h6><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</h6>
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Patient Info -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="info-box bg-light">
                                                <span class="info-box-icon"><i class="fas fa-user"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Pasien</span>
                                                    <span class="info-box-number">{{ auth()->user()->nama }}</span>
                                                    <span class="info-box-more">No. RM: {{ auth()->user()->no_rm ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pilih Jadwal Dokter -->
                                    <div class="form-group">
                                        <label for="id_jadwal_periksa">
                                            <i class="fas fa-user-md"></i> Pilih Jadwal Dokter <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 @error('id_jadwal_periksa') is-invalid @enderror"
                                                id="id_jadwal_periksa" name="id_jadwal_periksa" required>
                                            <option value="">-- Pilih Jadwal Dokter --</option>
                                            @if(isset($jadwalPeriksas))
                                                @foreach($jadwalPeriksas as $jadwal)
                                                    <option value="{{ $jadwal->id }}"
                                                        {{ old('id_jadwal_periksa') == $jadwal->id ? 'selected' : '' }}>
                                                        Dr. {{ $jadwal->dokter->nama }} - {{ $jadwal->dokter->poli->nama_poli }}
                                                        ({{ $jadwal->hari }}: {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('id_jadwal_periksa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Keluhan -->
                                    <div class="form-group">
                                        <label for="keluhan">
                                            <i class="fas fa-comment-medical"></i> Keluhan <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('keluhan') is-invalid @enderror"
                                                  id="keluhan" name="keluhan" rows="5"
                                                  placeholder="Jelaskan keluhan Anda dengan detail..."
                                                  maxlength="500" required>{{ old('keluhan') }}</textarea>
                                        <small class="form-text text-muted">
                                            <span id="char-count">0</span>/500 karakter
                                        </small>
                                        @error('keluhan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Info Box -->
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
                                        <ul class="mb-0">
                                            <li>Pastikan jadwal yang dipilih sesuai dengan ketersediaan Anda</li>
                                            <li>Nomor antrian akan diberikan secara otomatis</li>
                                            <li>Datang 15 menit sebelum jadwal pemeriksaan</li>
                                            <li>Bawa dokumen identitas dan kartu BPJS (jika ada)</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('pasien.janjiPeriksa') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Buat Janji Periksa
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

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Character counter for keluhan textarea
            $('#keluhan').on('input', function() {
                const current = $(this).val().length;
                $('#char-count').text(current);

                if (current > 450) {
                    $('#char-count').addClass('text-warning');
                } else {
                    $('#char-count').removeClass('text-warning');
                }

                if (current >= 500) {
                    $('#char-count').addClass('text-danger').removeClass('text-warning');
                } else {
                    $('#char-count').removeClass('text-danger');
                }
            });

            // Trigger character count on page load
            $('#keluhan').trigger('input');

            // Form validation
            $('form').on('submit', function(e) {
                const jadwal = $('#id_jadwal_periksa').val();
                const keluhan = $('#keluhan').val().trim();

                if (!jadwal) {
                    e.preventDefault();
                    showAlert('error', 'Silakan pilih jadwal dokter terlebih dahulu!');
                    $('#id_jadwal_periksa').focus();
                    return false;
                }

                if (!keluhan) {
                    e.preventDefault();
                    showAlert('error', 'Silakan isi keluhan Anda!');
                    $('#keluhan').focus();
                    return false;
                }

                if (keluhan.length < 10) {
                    e.preventDefault();
                    showAlert('error', 'Keluhan minimal 10 karakter!');
                    $('#keluhan').focus();
                    return false;
                }

                // Show loading
                $(this).find('button[type="submit"]').prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
            });

            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';

                const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="${icon}"></i> ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;

                $('.card-body').prepend(alertHtml);

                // Scroll to top
                $('html, body').animate({
                    scrollTop: $('.content-wrapper').offset().top
                }, 500);

                // Auto dismiss after 5 seconds
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>
@endpush
@endif
