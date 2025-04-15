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
    <h1>pasient periksaSWS</h1>
{{--    <h1>{{$periksas}}</h1>--}}



@endsection



