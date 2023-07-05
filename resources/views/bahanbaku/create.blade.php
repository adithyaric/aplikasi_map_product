@extends('layouts.master')

@section('title', 'Tambah Bahan Baku')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Bahan Baku</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('bahanbaku.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Satuan Bahan Baku</label>
                                <select required class="form-control select2" name="satuan_id" data-placeholder="Pilih Satuan Bahan Baku"
                                    style="width: 100%;">
                                    @foreach ($satuans as $satuan)
                                        <option value="{{ $satuan->id }}"
                                            {{ old('satuan_id') == $satuan->id ? 'selected' : '' }}>{{ $satuan->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Bahan Baku</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Bahan Baku">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga Bahan Baku</label>
                                <input required type="text" class="form-control" name="harga"
                                    value="{{ old('harga') }}" placeholder="Masukkan Harga Bahan Baku">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Stok Bahan Baku</label>
                                <input required type="text" class="form-control" name="stock"
                                    value="{{ old('stock') }}" placeholder="Masukkan Stok Bahan Baku">
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('bahanbaku.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
