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
                    <h1 class="m-0">Edit Poli</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.poliMaster') }}">Data Poli</a></li>
                        <li class="breadcrumb-item active">Edit Poli</li>
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

            <!-- Edit Poli Card -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Data Poli
                    </h3>
                </div>
                <form method="POST" action="{{ route('admin.updatePoli', $poli->id) }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_poli') is-invalid @enderror"
                                           id="nama_poli" name="nama_poli"
                                           value="{{ old('nama_poli', $poli->nama_poli) }}"
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
                                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $poli->keterangan) }}</textarea>
                                    @error('keterangan')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Display additional info -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info"></i> Informasi:</h5>
                                    <p class="mb-1"><strong>ID Poli:</strong> {{ $poli->id }}</p>
                                    <p class="mb-1"><strong>Dibuat pada:</strong> {{ $poli->created_at ? $poli->created_at->format('d F Y, H:i:s') : '-' }}</p>
                                    <p class="mb-0"><strong>Terakhir diupdate:</strong> {{ $poli->updated_at ? $poli->updated_at->format('d F Y, H:i:s') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Poli
                                </button>
                                <a href="{{ route('admin.poliMaster') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo"></i> Reset Form
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preview Card -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i> Preview Data
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="description-block border-right">
                                <span class="description-percentage text-yellow">
                                    <i class="fas fa-hospital"></i>
                                </span>
                                <h5 class="description-header" id="preview-nama">{{ $poli->nama_poli }}</h5>
                                <span class="description-text">NAMA POLI</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="description-block">
                                <span class="description-percentage text-blue">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <h5 class="description-header" id="preview-keterangan">
                                    {{ $poli->keterangan ?: 'Tidak ada keterangan' }}
                                </h5>
                                <span class="description-text">KETERANGAN</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Live preview update
            $('#nama_poli').on('input', function() {
                var value = $(this).val() || 'Nama Poli';
                $('#preview-nama').text(value);
            });

            $('#keterangan').on('input', function() {
                var value = $(this).val() || 'Tidak ada keterangan';
                $('#preview-keterangan').text(value);
            });

            // Form validation
            $('form').on('submit', function(e) {
                var namaPoli = $('#nama_poli').val().trim();

                if (namaPoli === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Nama poli harus diisi!',
                        confirmButtonText: 'OK'
                    });
                    $('#nama_poli').focus();
                    return false;
                }

                // Show loading
                $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
            });

            // Reset button functionality
            $('button[type="reset"]').on('click', function() {
                setTimeout(function() {
                    $('#preview-nama').text('{{ $poli->nama_poli }}');
                    $('#preview-keterangan').text('{{ $poli->keterangan ?: "Tidak ada keterangan" }}');
                }, 100);
            });
        });
    </script>

    <!-- SweetAlert2 for better alerts -->
    @if(session('success') || session('error'))
        <script>
            $(document).ready(function() {
                @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
                @endif

                @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
                @endif
            });
        </script>
    @endif
@endsection
