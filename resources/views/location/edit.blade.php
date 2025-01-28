@extends('layouts.master')

@section('title', 'Edit Lokasi')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Lokasi</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('locations.update', $location->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lokasi</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name', $location->name) }}" placeholder="Masukkan Nama Lokasi">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Koordinat Lokasi</label>
                                    <textarea name="coordinates" class="form-control" id="coordinates" cols="30" rows="10">{{ old('coordinates', $location->coordinates) }}</textarea>
                                @error('coordinates')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('locations.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
