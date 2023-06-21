@extends('layouts.master')

@section('title', 'Edit Kustomer')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Kustomer</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kustomer</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name', $customer->name) }}" placeholder="Masukkan Nama Kustomer">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nomor HP</label>
                                <input required type="text" class="form-control" name="no_hp"
                                    value="{{ old('no_hp', $customer->no_hp) }}" placeholder="Masukkan Nomor HP">
                                @error('no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Alamat</label>
                                <input required type="text" class="form-control" name="alamat"
                                    value="{{ old('alamat', $customer->alamat) }}" placeholder="Masukkan Alamat">
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('customer.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
