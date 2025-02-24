@extends('layouts.master')

@section('title', 'Users')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Users
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route('users.create') }}" class="btn btn-md bg-green">Tambah</a>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Users</td>
                                    <td>No Whatsapp</td>
                                    <td>Role</td>
                                    <td>Lokasi</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($users as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->role }}</td>
                                    <td>
                                        @if (isset($value->locations))
                                            <ul>
                                            @foreach ($value->locations as $location)
                                                <li>{{ $location->parent->name }} : {{ $location->name }}</li>
                                            @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('users.edit', $value->id) }}">Edit</a>
                                        <form action="{{ route('users.destroy', $value->id) }}" method="post"
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
