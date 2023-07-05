@extends('layouts.master')

@section('title', 'Solar Pengiriman')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Solar Pengiriman</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('pengiriman.solar.update', $pengiriman->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Input Banyak Solar</label>
                                <input required type="text" class="form-control" name="solar" value="{{ old('solar', $pengiriman->solar) }}" placeholder="Masukkan Jumlah Solar">
                                @error('solar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Penjualan</label>
                                <input required type="text" class="form-control" name="penjualan" value="{{ old('penjualan', $pengiriman->penjualan->no_invoice) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="text" class="form-control" name="jml_product" value="{{ old('jml_product', $pengiriman->jml_product) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pengiriman</label>
                                <input required type="text" class="form-control" name="tgl_pengiriman" value="{{ old('tgl_pengiriman', $pengiriman->tgl_pengiriman) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Jam</label>
                                <input required type="text" class="form-control" name="jam" value="{{ old('jam', $pengiriman->jam) }}" readonly>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('pengiriman.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
