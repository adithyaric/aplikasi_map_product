@extends('layouts.master')

@section('title', 'Bahan Baku')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Bahan Baku
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('bahanbaku.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Bahan Baku</td>
                                    <td>Harga</td>
                                    <td>Stok</td>
                                    <td>Satuan</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($bahanbakus as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>@currency($value->harga)</td>
                                    <td>{{ $value->stock }}</td>
                                    <td>{{ $value->satuan->name }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('bahanbaku.edit', $value->id) }}">Edit</a>
                                        <form action="{{ route('bahanbaku.destroy', $value->id) }}" method="post"
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
