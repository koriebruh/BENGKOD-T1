@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Bagian Daftar Obat -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Master Data Obat</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalTambahObat">
                            Tambah Obat
                        </button>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Kemasan</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($obats as $index => $obat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $obat->nama_obat }}</td>
                                        <td>{{ $obat->kemasan }}</td>
                                        <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditObat{{ $obat->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalHapusObat{{ $obat->id }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Obat -->
                                    <div class="modal fade" id="modalEditObat{{ $obat->id }}" tabindex="-1"
                                         aria-labelledby="editObatLabel{{ $obat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editObatLabel{{ $obat->id }}">Edit
                                                        Obat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('dokter.obat.update', $obat->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="edit_nama_obat{{ $obat->id }}"
                                                                   class="form-label">Nama Obat</label>
                                                            <input type="text" class="form-control"
                                                                   id="edit_nama_obat{{ $obat->id }}" name="nama_obat"
                                                                   value="{{ $obat->nama_obat }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_kemasan{{ $obat->id }}" class="form-label">Kemasan</label>
                                                            <input type="text" class="form-control"
                                                                   id="edit_kemasan{{ $obat->id }}" name="kemasan"
                                                                   value="{{ $obat->kemasan }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_harga{{ $obat->id }}" class="form-label">Harga
                                                                (Rp)</label>
                                                            <input type="number" class="form-control"
                                                                   id="edit_harga{{ $obat->id }}" name="harga"
                                                                   value="{{ $obat->harga }}" min="0" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus Obat -->
                                    <div class="modal fade" id="modalHapusObat{{ $obat->id }}" tabindex="-1"
                                         aria-labelledby="hapusObatLabel{{ $obat->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapusObatLabel{{ $obat->id }}">
                                                        Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus obat
                                                    <strong>{{ $obat->nama_obat }}</strong>?
                                                </div>
                                                <form action="{{ route('dokter.obat.destroy', $obat->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data obat</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="modalTambahObat" tabindex="-1" aria-labelledby="tambahObatLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahObatLabel">Tambah Obat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dokter.obat.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                        </div>
                        <div class="mb-3">
                            <label for="kemasan" class="form-label">Kemasan</label>
                            <input type="text" class="form-control" id="kemasan" name="kemasan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Jika ada error pada form, tampilkan modal yang sesuai
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->any())
            @if(old('_method') == 'PUT')
            // Untuk form edit
            document.getElementById('modalEditObat{{ old("id") }}')?.show();
            @else
            // Untuk form tambah
            new bootstrap.Modal(document.getElementById('modalTambahObat')).show();
            @endif
            @endif
        });
    </script>
@endsection
