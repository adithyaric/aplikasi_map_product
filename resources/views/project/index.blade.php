@extends('layouts.master')

@section('title', 'Project')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Project
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    {{-- <form action="{{ route('project.export') }}" method="GET"> --}}
                    {{-- <div class="form-group"> --}}
                    {{-- <input type="text" name="tanggal" id="tanggal" class="" value="{{ old('tanggal') }}" /> --}}
                    {{-- <button class="btn btn-primary" type="submit">Export</button> --}}
                    {{-- </div> --}}
                    {{-- </form> --}}
                    <div class="box-header">
                        <a href="{{ route('project.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Kustomer</td>
                                    <td>Nama Product</td>
                                    <td>Jumlah Product</td>
                                    <td>Durasi</td>
                                    <td>Keterangan</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($projects as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->customer->name }}</td>
                                    <td>{{ $value->product->name }}</td>
                                    <td>{{ $value->jml_product }}</td>
                                    <td>
                                        @php
                                            $dates = explode(' - ', $value->durasi);
                                            $start_date = \Carbon\Carbon::parse($dates[0])->format('d-m-Y');
                                            $end_date = \Carbon\Carbon::parse($dates[1])->format('d-m-Y');
                                        @endphp

                                        {{ $start_date }} - {{ $end_date }}
                                    </td>
                                    <td>{{ $value->keterangan }}</td>
                                    <td>
                                        <form action="{{ route('projects.updateStatus', $value->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="border-0 btn btn-{{ $value->status === 'proses' ? 'primary' : 'success' }}"
                                                type="submit">{{ $value->status }}</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('project.edit', $value->id) }}">Edit</a>
                                        <a class="btn btn-info" href="{{ route('project.show', $value->id) }}">Show</a>
                                        <form action="{{ route('project.destroy', $value->id) }}" method="post"
                                            style="display: inline;">
                                            @method('delete')
                                            @csrf
                                            <button class="border-0 btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            var startDate = new Date();
            var endDate = new Date();

            $('#tanggal').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'YYYY-MM-DD H:mm',
                startDate: startDate,
                endDate: endDate
            });
        });
    </script>
@endsection
