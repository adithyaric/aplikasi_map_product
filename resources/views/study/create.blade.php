@extends('layouts.master')

@section('title', 'Tambah Prodi')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Prodi</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('studies.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Nama Prodi</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Prodi">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Kode Prodi</label>
                                <input required type="text" class="form-control" name="code"
                                    value="{{ old('code') }}" placeholder="Masukkan Kode Prodi">
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('studies.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
