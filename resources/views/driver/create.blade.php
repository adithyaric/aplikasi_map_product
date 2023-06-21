@extends('layouts.master')

@section('title', 'Tambah Driver')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Driver</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('driver.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Nama Driver</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Driver">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Nomor HP</label>
                                <input required type="text" class="form-control" name="no_plat"
                                    value="{{ old('no_plat') }}" placeholder="Masukkan Nomor HP">
                                @error('no_plat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('driver.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
