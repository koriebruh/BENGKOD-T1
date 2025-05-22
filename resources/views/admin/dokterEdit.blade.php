@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.obatMaster') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                ObatMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.dokterMaster') }}" class="nav-link active"><i
                    class="nav-icon fas fa-user-md"></i> DokterMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.pasienMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-user-injured"></i> PasienMaster</a></li>
        <li class="nav-item"><a href="{{ route('admin.poliMaster') }}" class="nav-link"><i
                    class="nav-icon fas fa-hospital"></i> PoliMaster</a></li>
    </ul>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Data Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dokterMaster') }}">Data Dokter</a></li>
                        <li class="breadcrumb-item active">Edit Dokter</li>
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
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Edit Form Card -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-edit"></i> Edit Data Dokter
                            </h3>
                        </div>
                        <form action="{{ url('/admin/dokter/update/' . $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_ktp">No KTP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                                   id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}"
                                                   placeholder="Masukkan nama lengkap dokter" required>
                                            @error('no_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Dokter <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name', $user->name) }}"
                                                   placeholder="Masukkan nama lengkap dokter" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email" value="{{ old('email', $user->email) }}"
                                                   placeholder="dokter@example.com" required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation" placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_hp">No. HP</label>
                                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                                   id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                                   placeholder="08xxxxxxxxxx">
                                            @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="poli_id">Poli <span class="text-danger">*</span></label>
                                            <select class="form-control @error('poli_id') is-invalid @enderror" id="poli_id" name="poli_id" required>
                                                <option value="">-- Pilih Poli --</option>
                                                @foreach($polis ?? [] as $poli)
                                                    <option value="{{ $poli->id }}"
                                                        {{ (old('poli_id', $user->poli_id) == $poli->id) ? 'selected' : '' }}>
                                                        {{ $poli->nama_poli }}
                                                        @if($poli->keterangan)
                                                            - {{ $poli->keterangan }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('poli_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                              id="alamat" name="alamat" rows="3"
                                              placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <input type="hidden" name="role" value="dokter">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.dokterMaster') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save"></i> Update Data
                                        </button>
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
                </div>

                <div class="col-md-4">
                    <!-- Info Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Informasi Dokter
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="description-block">
                                        <span class="description-percentage text-blue">
                                            <i class="fas fa-user-md"></i>
                                        </span>
                                        <h5 class="description-header">{{ $user->name }}</h5>
                                        <span class="description-text">NAMA DOKTER</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="description-block">
                                        <span class="description-percentage text-green">
                                            <i class="fas fa-hospital"></i>
                                        </span>
                                        <h5 class="description-header">
                                            {{ $user->poli->nama_poli ?? 'Belum Ditentukan' }}
                                        </h5>
                                        <span class="description-text">POLI SAAT INI</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-calendar"></i> Riwayat Data
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <strong>ID:</strong> {{ $user->id }}<br>
                                <strong>Dibuat:</strong> {{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }}<br>
                                <strong>Diupdate:</strong> {{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') : '-' }}<br>
                                <strong>Role:</strong> <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                            </p>
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

            // Password confirmation validation
            $('#password_confirmation').on('keyup', function() {
                var password = $('#password').val();
                var confirmPassword = $(this).val();

                if (password !== '' && password !== confirmPassword) {
                    $(this).addClass('is-invalid');
                    if ($(this).next('.invalid-feedback').length === 0) {
                        $(this).after('<div class="invalid-feedback">Password tidak cocok</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });

            // Form validation before submit
            $('form').on('submit', function(e) {
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();
                var selectedPoli = $('#poli_id').val();

                // Check if poli is selected
                if (selectedPoli === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Silakan pilih poli untuk dokter!',
                        confirmButtonText: 'OK'
                    });
                    $('#poli_id').focus();
                    return false;
                }

                // Check password confirmation if password is filled
                if (password !== '' && password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Konfirmasi password tidak cocok!',
                        confirmButtonText: 'OK'
                    });
                    $('#password_confirmation').focus();
                    return false;
                }

                // Show loading
                $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
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
