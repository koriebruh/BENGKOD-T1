@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.periksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Periksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.jadwalPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> JadwalPeriksa</a></li>
    </ul>
@endsection


@section('content')
    <section class="content">
        <h1>Dashboard</h1>
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$totalObat}}</h3>

                            <p>TOTAL OBAT</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$totalPeriksa}}<sup style="font-size: 20px"> ORANG </sup></h3>

                            <p>SUDAH DI PERIKSA</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$totalDokter}}</h3>

                            <p>TOTAL DOKTER</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$totalPelangan}}</h3>

                            <p>TOTAL PALANGGAN</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
    @if(session('welcome_message'))
        <p>{{ session('welcome_message') }}</p>
    @endif

    <h1>BioData</h1>
    @if(Auth::check())
        <p>ID, {{ Auth::user()->id }}!</p>
        <p>NAME, {{ Auth::user()->name }}!</p>
        <p>EMAIL, {{ Auth::user()->email }}!</p>
        <p>PASSWORD, {{ Auth::user()->password }}!</p>
        <p>NO HP, {{ Auth::user()->no_hp }}!</p>
        <p>ALAMAT, {{ Auth::user()->alamat }}!</p>

{{--        {{ route('dokter.dashboardEdit')}}--}}
        <a href="{{ route('dokter.dashboardEdit', ['id' => Auth::user()->id]) }}" class="btn btn-sm btn-info">
            <i class="fas fa-edit"></i> Edit anjay
        </a>

    @endif

@endsection



