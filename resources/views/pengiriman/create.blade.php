@extends('layouts.master')

@section('title', 'Tambah Pengiriman')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Pengiriman</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('pengiriman.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>penjualan</label>
                                <select required class="form-control select2" name="penjualan_id" id="penjualan_id"
                                    data-placeholder="Pilih penjualan" style="width: 100%;">
                                    <option value="null" selected disabled>Pilih Invoice Penjualan</option>
                                    @foreach ($penjualans as $penjualan)
                                        <option value="{{ $penjualan->id }}"
                                            {{ old('penjualan_id') == $penjualan->id ? 'selected' : '' }}>
                                            {{ $penjualan->no_invoice }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Driver</label>
                                <select required class="form-control select2" name="driver_id"
                                    data-placeholder="Pilih Driver" style="width: 100%;">
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}"
                                            {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Truck/No Kendaraan</label>
                                <select required class="form-control select2" name="truck_id"
                                    data-placeholder="Pilih Truck/No Kendaraan" style="width: 100%;">
                                    @foreach ($trucks as $truck)
                                        <option value="{{ $truck->id }}"
                                            {{ old('truck_id') == $truck->id ? 'selected' : '' }}>
                                            {{ $truck->no_plat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="text" class="form-control" id="jml_product" name="jml_product"
                                    value="{{ old('jml_product') }}" placeholder="Masukkan Jumlah Product" readonly>
                                @error('jml_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pengiriman</label>
                                <input required type="date" class="form-control" name="tgl_pengiriman"
                                    value="{{ old('tgl_pengiriman') }}" placeholder="Masukkan Tanggal Pengiriman">
                                @error('tgl_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Jam</label>
                                <input type="time" class="form-control" name="jam" value="{{ old('jam') }}"
                                    placeholder="Masukkan Jam">
                                @error('jam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">jarak</label>
                                <input required type="text" class="form-control" name="jarak"
                                    value="{{ old('jarak') }}" placeholder="Masukkan Jarak KM">
                                @error('jarak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Waktu Tempuh</label>
                                <input type="text" class="form-control" name="waktu_tempuh"
                                    value="{{ old('waktu_tempuh') }}" placeholder="Masukkan Waktu Tempuh">
                                @error('waktu_tempuh')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Untuk Pengecoran</label>
                                <input type="text" class="form-control" name="untuk_pengecoran"
                                    value="{{ old('untuk_pengecoran') }}">
                                @error('untuk_pengecoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi Pengecoran</label>
                                <input type="text" class="form-control" name="lokasi_pengecoran"
                                    value="{{ old('lokasi_pengecoran') }}">
                                @error('lokasi_pengecoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Dry Automatic</label>
                                <input type="text" class="form-control" name="dry_automatic"
                                    value="{{ old('dry_automatic') }}">
                                @error('dry_automatic')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group"> --}}
                            {{-- <label for="">Slump Permintaan</label> --}}
                            {{-- <input type="text" class="form-control" name="slump_permintaan" --}}
                            {{-- value="{{ old('slump_permintaan') }}"> --}}
                            {{-- @error('slump_permintaan') --}}
                            {{-- <div class="invalid-feedback"> --}}
                            {{-- {{ $message }} --}}
                            {{-- </div> --}}
                            {{-- @enderror --}}
                            {{-- </div> --}}
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
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#penjualan_id').on('change', function() {
                var penjualanId = $(this).val();

                $.get('/penjualans/' + penjualanId + '/data', function(data) {
                    $('#jml_product').val(data.total_barang);
                });
            });
        });
    </script>
@endsection
