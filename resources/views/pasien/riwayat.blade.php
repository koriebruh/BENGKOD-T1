@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('pasien.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('pasien.periksa') }}" class="nav-link"> <i
                    class="nav-icon fas fa-th"></i>
                Periksa</a></li>
        <li class="nav-item"><a href="{{ route('pasien.riwayat') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Riwayat Periksa</a></li>
    </ul>
@endsection

@section('content')

    <h1>INI RIWAYAT PERIKSA Sir {{ Auth::user()->name }} </h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>KODE PERIKSA</th>
            <th>Nama Dokter</th>
            <th>Tanggal Periksa</th>
            <th>Catatan</th>
            <th>Obat</th>
            <th>Biaya Periksa</th>
            <th>Detail Biaya</th>
        </tr>
        </thead>
        <tbody>
        @foreach($periksas as $periksa)
            <tr>
                <td>PR{{ $periksa->id }}</td>
                <td>{{ $periksa->dokter->name ?? 'Tidak Diketahui' }}</td>
                <td>{{ $periksa->tgl_periksa }}</td>
                <td>{{ $periksa->catatan }}</td>
                <td>
                    @foreach($periksa->obat as $obat)
                        {{ $obat->nama_obat }} <br>
                    @endforeach
                </td>
                <td>Rp. {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $periksa->id }}">
                        Lihat Detail
                    </button>

                    <!-- Modal Detail Biaya -->
                    <div class="modal fade" id="detailModal{{ $periksa->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $periksa->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $periksa->id }}">Detail Biaya - PR{{ $periksa->id }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        @php
                                            $totalObat = 0;
                                            foreach($periksa->obat as $obat) {
                                                $totalObat += $obat->harga;
                                            }
                                            $biayaKonsultasi = $periksa->biaya_periksa - $totalObat;
                                        @endphp
                                        <tr>
                                            <th>Biaya Konsultasi</th>
                                            <td>Rp. {{ number_format($biayaKonsultasi, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Obat</th>
                                            <td>
                                                @foreach($periksa->obat as $obat)
                                                    {{ $obat->nama_obat }} ({{ $obat->kemasan }}) - Rp. {{ number_format($obat->harga, 0, ',', '.') }}<br>
                                                @endforeach
                                                <hr>
                                                <strong>Total Obat: Rp. {{ number_format($totalObat, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th>Total Biaya</th>
                                            <td><strong>Rp. {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection



