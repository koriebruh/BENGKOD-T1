@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.memeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-stethoscope"></i> Memeriksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.jadwalPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-calendar-alt"></i> Jadwal Periksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.historyPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> historyPeriksa</a></li>
    </ul>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Profile Dokter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
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
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
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
                    <!-- Edit Profile Form Card -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-edit"></i> Edit Profile Dokter
                            </h3>
                        </div>
                        <form action="{{ route('dokter.updateProfile', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_ktp">No KTP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('no_ktp') is-invalid @enderror"
                                                   id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}"
                                                   placeholder="Masukkan nomor KTP" required>
                                            @error('no_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name', $user->name) }}"
                                                   placeholder="Masukkan nama lengkap" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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

                                <hr>
                                <h5 class="text-primary"><i class="fas fa-lock"></i> Ubah Password (Opsional)</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_password">Password Saat Ini</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                   id="current_password" name="current_password"
                                                   placeholder="Masukkan password saat ini">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                            @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password Baru</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" placeholder="Masukkan password baru">
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation" placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
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
                    <!-- Profile Info Card -->
                    <div class="card card-widget widget-user">
                        <div class="widget-user-header bg-primary">
                            <h3 class="widget-user-username">{{ $user->name }}</h3>
                            <h5 class="widget-user-desc">Dokter {{ $user->poli->nama_poli ?? '' }}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ asset('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $user->id }}</h5>
                                        <span class="description-text">ID DOKTER</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $totalPeriksa ?? 0 }}</h5>
                                        <span class="description-text">PASIEN</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">
                                            <span class="badge badge-success">Aktif</span>
                                        </h5>
                                        <span class="description-text">STATUS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Informasi Profile
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-muted">
                                        <strong>Email:</strong> {{ $user->email }}<br>
                                        <strong>No. HP:</strong> {{ $user->no_hp ?? 'Belum diisi' }}<br>
                                        <strong>Poli:</strong> {{ $user->poli->nama_poli ?? 'Belum ditentukan' }}<br>
                                        <strong>Bergabung:</strong> {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}<br>
                                        <strong>Update Terakhir:</strong> {{ $user->updated_at ? $user->updated_at->format('d F Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt"></i> Quick Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('dokter.memeriksa') }}" class="btn btn-success btn-block mb-2">
                                    <i class="fas fa-stethoscope mr-2"></i>
                                    Mulai Periksa
                                </a>
                                <a href="{{ route('dokter.jadwalPeriksa') }}" class="btn btn-info btn-block mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Kelola Jadwal
                                </a>
                                <a href="{{ route('dokter.dashboard') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Kembali ke Dashboard
                                </a>
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

            // Show/hide password fields based on current password
            $('#current_password').on('input', function() {
                var currentPassword = $(this).val();
                if (currentPassword !== '') {
                    $('#password, #password_confirmation').prop('required', true);
                    $('#password').closest('.form-group').find('label').html('Password Baru <span class="text-danger">*</span>');
                    $('#password_confirmation').closest('.form-group').find('label').html('Konfirmasi Password Baru <span class="text-danger">*</span>');
                } else {
                    $('#password, #password_confirmation').prop('required', false);
                    $('#password').closest('.form-group').find('label').html('Password Baru');
                    $('#password_confirmation').closest('.form-group').find('label').html('Konfirmasi Password Baru');
                }
            });

            // Form validation before submit
            $('form').on('submit', function(e) {
                var currentPassword = $('#current_password').val();
                var password = $('#password').val();
                var confirmPassword = $('#password_confirmation').val();

                // Check if current password is provided when changing password
                if (password !== '' && currentPassword === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Silakan masukkan password saat ini untuk mengubah password!',
                        confirmButtonText: 'OK'
                    });
                    $('#current_password').focus();
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
                $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
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
