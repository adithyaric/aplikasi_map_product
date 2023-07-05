@extends('layouts.master')

@section('title', 'Penjualan')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Penjualan
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('penjualan.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Kustomer</td>
                                    <td>Nama Project</td>
                                    <td>Nama Produk</td>
                                    <td>Total</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($penjualans as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->customer->name }}</td>
                                    <td>{{ $value->project->keterangan }}</td>
                                    <td>{{ $value->project->product->name }}</td>
                                    <td>{{ $value->total }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('penjualan.edit', $value->id) }}">Edit</a>
                                        <form action="{{ route('penjualan.destroy', $value->id) }}" method="post"
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
