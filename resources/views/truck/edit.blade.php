@extends('layouts.master')

@section('title', 'Edit Truck')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Truck</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('truck.update', $truck->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor Plat</label>
                                <input required type="text" class="form-control" name="no_plat"
                                    value="{{ old('no_plat', $truck->no_plat) }}" placeholder="Masukkan Nomor Plat">
                                @error('no_plat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('truck.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
