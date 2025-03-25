@extends('components.layout')
@section('content')
    <h1>Baka baka baka Paisen</h1>

    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Responsive Hover Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                   placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Tanggal Periksa</th>
                            <th>Catatan Dokter</th>
                            <th>Biaya periksa</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($periksas as $p)
                            <tr>
                                {{--                                <td>{{ $loop->$iteration }}</td>--}}
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->pasien->name }}</td>
                                <td>{{ $p->tgl_periksa}}</td>
                                <td>{{ $p->catatan }}.</td>
                                <td>{{ $p->biaya_periksa }}.</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

@endsection



