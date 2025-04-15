@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.obat') }}" class="nav-link"> <i class="nav-icon fas fa-th"></i>
                Obat</a></li>
        <li class="nav-item"><a href="{{ route('dokter.periksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Periksa</a></li>
    </ul>
@endsection

@section('content')
    <h1 class="display-4 text-primary">Edit Pemeriksaan PR{{ $periksa->id }}</h1>

    <form action="{{ route('dokter.updatePeriksa', $periksa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Pasien -->
        <div class="form-group">
            <label for="id_pasien">Pasien</label>
            <select name="id_pasien" class="form-control" required>
                <option value="">Pilih Pasien</option>
                @foreach($pasienList as $pasien)
                    <option value="{{ $pasien->id }}"
                        {{ $periksa->id_pasien == $pasien->id ? 'selected' : '' }}>
                        {{ $pasien->name }}
                    </option>
                @endforeach
            </select>
            @error('id_pasien')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tanggal Pemeriksaan -->
        <div class="form-group">
            <label for="tgl_periksa">Tanggal Pemeriksaan</label>
            <input type="date" name="tgl_periksa" class="form-control" value="{{ $periksa->tgl_periksa }}" required>
            @error('tgl_periksa')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Catatan -->
        <div class="form-group">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" class="form-control">{{ old('catatan', $periksa->catatan) }}</textarea>
            @error('catatan')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Biaya Pemeriksaan -->
        <div class="form-group">
            <label for="biaya_periksa">Biaya Pemeriksaan</label>
            <input type="number" name="biaya_periksa" class="form-control" value="{{ $periksa->biaya_periksa }}" required>
            @error('biaya_periksa')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Obat -->
        <div class="form-group">
            <label for="obat">Obat yang Diberikan</label>
            <div class="checkbox-group">
                @foreach($obatList as $obat)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="obat[]" value="{{ $obat->id }}"
                            {{ in_array($obat->id, $periksa->obat->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $obat->nama_obat }} ({{ $obat->kemasan }})
                        </label>
                    </div>
                @endforeach
            </div>
            @error('obat')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Pemeriksaan</button>
        <a href="{{ route('dokter.periksa') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
