@extends('components.layout')

@section('nav-content')
    <ul class="nav">
        <li class="nav-item"><a href="{{ route('dokter.dashboard') }}" class="nav-link"><i
                    class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('dokter.memeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> Memeriksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.jadwalPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> JadwalPeriksa</a></li>
        <li class="nav-item"><a href="{{ route('dokter.historyPeriksa') }}" class="nav-link"><i
                    class="nav-icon fas fa-book"></i> historyPeriksa</a></li>
    </ul>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-3">
                <div class="col-12">
                    <h1 class="m-0">Dashboard Dokter</h1>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$totalPelangan}}</h3>
                            <p>TOTAL PELANGGAN</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            @if(session('welcome_message'))
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon fas fa-check"></i>
                            {{ session('welcome_message') }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Card -->
            @if(Auth::check())
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user-md mr-2"></i>
                                    Biodata Dokter
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-bold">ID Dokter:</label>
                                            <p class="text-muted">{{ Auth::user()->id }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold">No. KTP:</label>
                                            <p class="text-muted">{{ Auth::user()->no_ktp }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold">Nama Lengkap:</label>
                                            <p class="text-muted">{{ Auth::user()->name }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold">Email:</label>
                                            <p class="text-muted">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-bold">No. HP:</label>
                                            <p class="text-muted">{{ Auth::user()->no_hp }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold">Alamat:</label>
                                            <p class="text-muted">{{ Auth::user()->alamat }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-bold">Status:</label>
                                            <span class="badge badge-success">Aktif</span>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-bold">Poli:</label>
                                            <p class="text-muted">{{ Auth::user()->poli->nama_poli }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('dokter.dashboardEdit', ['id' => Auth::user()->id]) }}"
                                   class="btn btn-primary">
                                    <i class="fas fa-edit mr-1"></i> Edit Profil
                                </a>
                                <button type="button" class="btn btn-secondary ml-2">
                                    <i class="fas fa-print mr-1"></i> Cetak Profil
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Quick Actions
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
                                        Lihat Jadwal
                                    </a>
                                    <button class="btn btn-warning btn-block mb-2">
                                        <i class="fas fa-chart-bar mr-2"></i>
                                        Laporan Harian
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Image Card -->
                        <div class="card card-widget widget-user">
                            <div class="widget-user-header bg-info">
                                <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                                <h5 class="widget-user-desc">Dokter</h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle elevation-2" src="{{ asset('adminlte/dist/img/user1-128x128.jpg') }}" alt="User Avatar">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">{{$totalPeriksa ?? 0}}</h5>
                                            <span class="description-text">PASIEN</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">35</h5>
                                            <span class="description-text">HARI AKTIF</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">4.9</h5>
                                            <span class="description-text">RATING</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
