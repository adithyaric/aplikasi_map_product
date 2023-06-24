@extends('layouts.master')

@section('title', 'Edit Penjualan')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Penjualan</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Customer</label>
                                <select required class="form-control select2" name="customer_id"
                                    data-placeholder="Pilih Customer" style="width: 100%;">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id', $penjualan->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Produk</label>
                                <select required class="form-control select2" name="product_id"
                                    data-placeholder="Pilih Produk" style="width: 100%;">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('product_id', $penjualan->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Total Barang</label>
                                <input required type="text" class="form-control" name="total_barang"
                                    value="{{ old('total_barang', $penjualan->total_barang) }}" placeholder="Masukkan Total Barang">
                                @error('total_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input required type="text" class="form-control" name="harga"
                                    value="{{ old('harga', $penjualan->harga) }}" placeholder="Masukkan Harga">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Total</label>
                                <input required type="text" class="form-control" name="total"
                                    value="{{ old('total', $penjualan->total) }}" placeholder="Masukkan Total">
                                @error('total')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Metode Pembayaran</label>
                                <input required type="text" class="form-control" name="metode_pembayaran"
                                    value="{{ old('metode_pembayaran', $penjualan->metode_pembayaran) }}" placeholder="Masukkan Metode Pembayaran">
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Penjualan</label>
                                <input required type="date" class="form-control" name="tgl_penjualan"
                                    value="{{ old('tgl_penjualan', $penjualan->tgl_penjualan) }}" placeholder="Masukkan Tanggal Penjualan">
                                @error('tgl_penjualan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('penjualan.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
