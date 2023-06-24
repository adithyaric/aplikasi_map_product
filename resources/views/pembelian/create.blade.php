@extends('layouts.master')

@section('title', 'Tambah Pembelian')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Pembelian</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('pembelian.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Kategori</label>
                                <select required class="form-control select2" name="category_id"
                                    data-placeholder="Pilih Kategori" style="width: 100%;">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bahan Baku</label>
                                <select required class="form-control select2" name="bahan_baku_id"
                                    data-placeholder="Pilih Bahan Baku" style="width: 100%;">
                                    @foreach ($bahan_bakus as $bahan_baku)
                                        <option value="{{ $bahan_baku->id }}"
                                            {{ old('bahan_baku_id') == $bahan_baku->id ? 'selected' : '' }}>
                                            {{ $bahan_baku->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input required type="text" class="form-control" name="harga"
                                    value="{{ old('harga') }}" placeholder="Masukkan Harga">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input required type="text" class="form-control" name="jumlah"
                                    value="{{ old('jumlah') }}" placeholder="Masukkan Jumlah">
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input required type="text" class="form-control" name="keterangan"
                                    value="{{ old('keterangan') }}" placeholder="Masukkan Keterangan">
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('pembelian.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
