@extends('layouts.master')

@section('title', 'Pengiriman')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Pengiriman
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    {{-- <form action="{{ route('pengiriman.export') }}" method="GET"> --}}
                    {{-- <div class="form-group"> --}}
                    {{-- <label for="">Export Pengiriman</label> --}}
                    {{-- <input type="text" name="tanggal" id="tanggal" class="form-input" value="{{ old('tanggal') }}" /> --}}
                    {{-- <button class="btn btn-primary" type="submit">Export</button> --}}
                    {{-- </div> --}}
                    {{-- </form> --}}
                    {{-- <form action="{{ route('pengiriman.daily') }}" method="GET"> --}}
                    {{-- <div class="form-group"> --}}
                    {{-- <label for="">Pengiriman Daily</label> --}}
                    {{-- <input type="date" name="tanggal" class="form-input" value="{{ old('tanggal') }}" /> --}}
                    {{-- <button class="btn btn-primary" type="submit">Export</button> --}}
                    {{-- </div> --}}
                    {{-- </form> --}}
                    <div class="box-header">
                        <a href="{{ route('pengiriman.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>No Invoice Penjualan</td>
                                    <td>Nama Driver</td>
                                    <td>Tanggal</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($pengirimans as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->penjualan->no_invoice }}</td>
                                    <td>{{ $value->driver->name }}</td>
                                    <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                    <td>{{ strtoupper($value->status) }}</td>
                                    <td>
                                        <a class="btn btn-warning"
                                            href="{{ route('pengiriman.edit', $value->id) }}">Edit</a>
                                        <a class="btn btn-info"
                                            href="{{ route('pengiriman.solar', ['pengiriman_id' => $value->id]) }}">
                                            Solar {{ $value->solar ?? 0 }} L
                                        </a>
                                        <form action="{{ route('pengiriman.destroy', $value->id) }}" method="post"
                                            style="display: inline;">
                                            @method('delete')
                                            @csrf
                                            <button class="border-0 btn btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                Hapus
                                            </button>
                                        </form>
                                        <form action="{{ route('pengiriman.nota') }}" method="GET">
                                            <div class="form-group">
                                                <input type="hidden" name="pengiriman_id" value="{{ $value->id }}" />
                                                <button class="btn btn-primary" type="submit">Export Nota</button>
                                            </div>
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
