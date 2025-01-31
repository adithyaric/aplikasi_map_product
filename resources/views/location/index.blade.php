@extends('layouts.master')

@section('title', 'Lokasi')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Lokasi
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('locations.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Lokasi</td>
                                    <td>Tipe</td>
                                    {{-- <td>Banyak Penyebaran (qty)</td> --}}
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($locations as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->type }}</td>
                                    {{-- <td>{{ $value->products->sum('pivot.quantity') }}</td> --}}
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('locations.edit', $value->id) }}">Edit</a>
                                        <form action="{{ route('locations.destroy', $value->id) }}" method="post"
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
