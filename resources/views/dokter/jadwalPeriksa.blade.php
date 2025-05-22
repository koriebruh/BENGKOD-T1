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


@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jadwal Periksa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Jadwal Periksa</li>
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
                        <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
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

                <!-- Info Jadwal Aktif -->
                @if(isset($activeSchedule))
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info-circle"></i> Jadwal Aktif Saat Ini</h5>
                        <strong>{{ ucfirst($activeSchedule->hari) }}</strong> -
                        {{ date('H:i', strtotime($activeSchedule->jam_mulai)) }} sampai {{ date('H:i', strtotime($activeSchedule->jam_selesai)) }}
                        <br><small>Hanya satu jadwal yang dapat aktif pada satu waktu.</small>
                    </div>
                @else
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan</h5>
                        Saat ini tidak ada jadwal yang aktif. Pasien tidak dapat mendaftar tanpa jadwal aktif.
                    </div>
                @endif

                <!-- Form Tambah Jadwal -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Jadwal Periksa</h3>
                    </div>
                    <form action="{{ route('dokter.storeJadwal') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hari">Hari <span class="text-danger">*</span></label>
                                        <select class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" required>
                                            <option value="">Pilih Hari</option>
                                            @foreach($hariOptions as $key => $value)
                                                <option value="{{ $key }}" {{ old('hari') == $key ? 'selected' : '' }}>
                                                    {{ ucfirst($value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror"
                                               id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                                        @error('jam_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror"
                                               id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                                        @error('jam_selesai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('jadwal'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('jadwal') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Jadwal
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Jadwal -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Jadwal Periksa</h3>
                    </div>
                    <div class="card-body">
                        @if($jadwalPeriksa->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Status</th>
                                        <th style="width: 200px">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jadwalPeriksa as $index => $jadwal)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucfirst($jadwal->hari) }}</td>
                                            <td>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</td>
                                            <td>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</td>
                                            <td>
                                                @if($jadwal->status == 1)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times"></i> Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Toggle Status Button -->
                                                <form action="{{ route('dokter.toggleStatusJadwal', $jadwal->id) }}"
                                                      method="POST" style="display: inline-block;"
                                                      onsubmit="return confirm('{{ $jadwal->status == 1 ? 'Apakah Anda yakin ingin menonaktifkan jadwal ini?' : 'Apakah Anda yakin ingin mengaktifkan jadwal ini? Jadwal aktif lainnya akan dinonaktifkan.' }}')">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if($jadwal->status == 1)
                                                        <button type="submit" class="btn btn-warning btn-sm" title="Nonaktifkan Jadwal">
                                                            <i class="fas fa-toggle-off"></i>
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-success btn-sm" title="Aktifkan Jadwal">
                                                            <i class="fas fa-toggle-on"></i>
                                                        </button>
                                                    @endif
                                                </form>

                                                <a href="{{ route('dokter.editJadwal', $jadwal->id) }}"
                                                   class="btn btn-info btn-sm" title="Edit Jadwal">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('dokter.deleteJadwal', $jadwal->id) }}"
                                                      method="POST" style="display: inline-block;"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Jadwal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Informasi</h5>
                                Belum ada jadwal periksa yang ditambahkan.
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Card Info Penting -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i> Informasi Penting
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li><strong>Jadwal Aktif:</strong> Hanya satu jadwal yang dapat aktif pada satu waktu</li>
                            <li><strong>Status Toggle:</strong> Gunakan tombol toggle untuk mengaktifkan/menonaktifkan jadwal dengan cepat</li>
                            <li><strong>Konflik Waktu:</strong> Sistem akan mencegah jadwal yang bertabrakan pada hari yang sama</li>
                            <li><strong>Pendaftaran Pasien:</strong> Pasien hanya dapat mendaftar pada jadwal yang statusnya aktif</li>
                            <li><strong>Otomatisasi:</strong> Mengaktifkan jadwal baru akan otomatis menonaktifkan jadwal yang sedang aktif</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection
