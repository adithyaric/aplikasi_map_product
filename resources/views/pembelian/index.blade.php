@extends('layouts.master')

@section('title', 'Pembelian')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Pembelian
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    {{-- <form action="{{ route('pembelian.export') }}" method="GET"> --}}
                    {{-- <div class="form-group"> --}}
                    {{-- <input type="text" name="tanggal" id="tanggal" class="" value="{{ old('tanggal') }}" /> --}}
                    {{-- <button class="btn btn-primary" type="submit">Export</button> --}}
                    {{-- </div> --}}
                    {{-- </form> --}}
                    <div class="box-header">
                        <a href="{{ route('pembelian.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Bahan Baku</td>
                                    <td>Jumlah</td>
                                    <td>Keterangan</td>
                                    <td>Status</td>
                                    <td>Tgl</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($pembelians as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->bahanbaku->name }}</td>
                                    <td>{{ $value->jumlah }}</td>
                                    <td>{{ $value->keterangan }}</td>
                                    <td>
                                        @if (auth()->user()->role == 'Owner')
                                            <button
                                                class="border-0 btn btn-{{ $value->status === 'blm_lunas' ? 'primary' : 'success' }}"
                                                type="submit">{{ $value->status === 'blm_lunas' ? 'BELUM LUNAS' : 'LUNAS' }}</button>
                                        @else
                                            <form action="{{ route('pembelians.updateStatus', $value->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    class="border-0 btn btn-{{ $value->status === 'blm_lunas' ? 'primary' : 'success' }}"
                                                    type="submit">{{ $value->status === 'blm_lunas' ? 'BELUM LUNAS' : 'LUNAS' }}</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $value->tgl_dibuat }}</td>
                                    <td>
                                        <a class="btn btn-warning"
                                            href="{{ route('pembelian.edit', $value->id) }}">Edit</a>
                                        <form action="{{ route('pembelian.destroy', $value->id) }}" method="post"
                                            style="display: inline;">
                                            @method('delete')
                                            @csrf
                                            <button class="border-0 btn btn-danger "
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
