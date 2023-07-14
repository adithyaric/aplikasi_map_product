@extends('layouts.master')

@section('title', 'Edit Pembelian')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Pembelian</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Bahan Baku</label>
                                <select required class="form-control select2" name="bahan_baku_id"
                                    data-placeholder="Pilih Bahan Baku" style="width: 100%;">
                                    @foreach ($bahan_bakus as $bahan_baku)
                                        <option value="{{ $bahan_baku->id }}"
                                            {{ old('bahan_baku_id', $pembelian->bahan_baku_id) == $bahan_baku->id ? 'selected' : '' }}>
                                            {{ $bahan_baku->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select required class="form-control select2" name="supplier_id"
                                    data-placeholder="Pilih Supplier" style="width: 100%;">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ old('supplier_id', $pembelian->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Harga</label>
                                <input required type="text" class="numeral-mask form-control" name="harga"
                                    value="{{ old('harga', $pembelian->harga) }}" placeholder="Masukkan Harga">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah</label>
                                <input required type="text" class="form-control" name="jumlah"
                                    value="{{ old('jumlah', $pembelian->jumlah) }}" placeholder="Masukkan Jumlah">
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input required type="text" class="form-control" name="keterangan"
                                    value="{{ old('keterangan', $pembelian->keterangan) }}" placeholder="Masukkan Keterangan">
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Dibuat</label>
                                <input required type="date" class="form-control" name="tgl_dibuat"
                                    value="{{ old('tgl_dibuat', $pembelian->tgl_dibuat) }}" placeholder="Masukkan Tanggal Dibuat">
                                @error('tgl_dibuat')
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
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.numeral-mask').mask("#,##0", {
                reverse: true
            });
        });
    </script>
@endsection
