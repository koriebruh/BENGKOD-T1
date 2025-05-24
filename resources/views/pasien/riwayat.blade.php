@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('pasien.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('pasien.janjiPeriksa') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                Periksa</a></li>
        <li class="nav-item"><a href="{{ route('pasien.riwayat') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Riwayat Periksa</a></li>
    </ul>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history mr-1"></i>
                Riwayat Pemeriksaan Saya
            </h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ count($periksas) }} Pemeriksaan</span>
            </div>
        </div>
        <div class="card-body">
            @if(count($periksas) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="riwayatTable">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal Periksa</th>
                            <th>Dokter</th>
                            <th>Keluhan</th>
                            <th>Catatan</th>
                            <th>Obat</th>
                            <th>Biaya</th>
                            <th width="10%">Detail</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($periksas as $index => $periksa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                        <span class="badge badge-primary">
                                            {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y') }}
                                        </span>
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <strong>{{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->name ?? 'Dokter tidak ditemukan' }}</strong>
                                    @if(isset($periksa->janjiPeriksa->jadwalPeriksa->poli))
                                        <br><small class="text-muted">{{ $periksa->janjiPeriksa->jadwalPeriksa->poli }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($periksa->janjiPeriksa && $periksa->janjiPeriksa->keluhan)
                                        <p class="mb-0">{{ Str::limit($periksa->janjiPeriksa->keluhan, 100) }}</p>
                                        @if(strlen($periksa->janjiPeriksa->keluhan) > 100)
                                            <small>
                                                <a href="#" class="text-primary" data-toggle="modal"
                                                   data-target="#keluhanModal{{ $periksa->id }}">
                                                    Lihat selengkapnya...
                                                </a>
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($periksa->catatan)
                                        <p class="mb-0">{{ Str::limit($periksa->catatan, 100) }}</p>
                                        @if(strlen($periksa->catatan) > 100)
                                            <small>
                                                <a href="#" class="text-primary" data-toggle="modal"
                                                   data-target="#catatanModal{{ $periksa->id }}">
                                                    Lihat selengkapnya...
                                                </a>
                                            </small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($periksa->obat && count($periksa->obat) > 0)
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            @foreach($periksa->obat as $obat)
                                                <span class="badge badge-success mb-1">{{ $obat->nama_obat }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">Tidak ada obat</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-success">
                                        Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $periksa->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modals untuk Detail -->
                @foreach($periksas as $periksa)
                    <!-- Modal Detail Lengkap -->
                    <div class="modal fade" id="detailModal{{ $periksa->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title">
                                        <i class="fas fa-file-medical"></i>
                                        Detail Pemeriksaan - {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y') }}
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6><strong>Informasi Pemeriksaan</strong></h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Tanggal:</strong></td>
                                                    <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Dokter:</strong></td>
                                                    <td>{{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->name ?? 'Dokter tidak ditemukan' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Biaya:</strong></td>
                                                    <td><strong class="text-success">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6><strong>Obat yang Diberikan</strong></h6>
                                            @if($periksa->obat && count($periksa->obat) > 0)
                                                <ul class="list-group list-group-flush">
                                                    @foreach($periksa->obat as $obat)
                                                        <li class="list-group-item p-2">
                                                            <strong>{{ $obat->nama_obat }}</strong>
                                                            <br><small class="text-muted">{{ $obat->kemasan }}</small>
                                                            <span class="badge badge-secondary float-right">
                                                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                                            </span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">Tidak ada obat yang diberikan</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6><strong>Keluhan</strong></h6>
                                            @if($periksa->janjiPeriksa && $periksa->janjiPeriksa->keluhan)
                                                <div class="alert alert-light">
                                                    {{ $periksa->janjiPeriksa->keluhan }}
                                                </div>
                                            @else
                                                <div class="alert alert-light">
                                                    <span class="text-muted">Tidak ada keluhan tercatat</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($periksa->catatan)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6><strong>Catatan Dokter</strong></h6>
                                                <div class="alert alert-info">
                                                    {{ $periksa->catatan }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Keluhan -->
                    @if($periksa->janjiPeriksa && $periksa->janjiPeriksa->keluhan && strlen($periksa->janjiPeriksa->keluhan) > 100)
                        <div class="modal fade" id="keluhanModal{{ $periksa->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Keluhan Lengkap</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $periksa->janjiPeriksa->keluhan }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Modal Catatan -->
                    @if($periksa->catatan && strlen($periksa->catatan) > 100)
                        <div class="modal fade" id="catatanModal{{ $periksa->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Catatan Dokter Lengkap</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $periksa->catatan }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum Ada Riwayat Pemeriksaan</h4>
                    <p class="text-muted">Anda belum memiliki riwayat pemeriksaan. Silakan buat janji periksa terlebih dahulu.</p>
                    <a href="{{ route('pasien.showJanjiPeriksaForm') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus mr-1"></i>
                        Buat Janji Periksa
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .modal-lg {
            max-width: 900px;
        }
        .table td {
            vertical-align: middle;
        }
        .badge {
            font-size: 11px;
        }
        .list-group-item {
            border-left: none;
            border-right: none;
        }
        .alert-light {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            $("#riwayatTable").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "order": [[ 1, "desc" ]], // Sort by date descending
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "pageLength": 10,
                "columnDefs": [
                    { "orderable": false, "targets": [7] } // Disable sorting for Detail column
                ]
            });
        });
    </script>
@stop
