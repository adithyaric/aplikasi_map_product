@extends('layouts.master')

@section('title', 'Tambah Penjualan')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Penjualan</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">No Invoice</label>
                                <input required type="text" class="form-control" name="no_invoice"
                                    value="{{ old('no_invoice') }}" placeholder="Masukkan no_invoice">
                                @error('no_invoice')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Customer</label>
                                <select required class="form-control select2" name="customer_id"
                                    data-placeholder="Pilih Customer" style="width: 100%;">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Project</label>
                                <select required class="form-control select2" name="project_id"
                                    data-placeholder="Pilih Project" style="width: 100%;" id="project-select">
                                    <option value="null" selected disabled>Pilih Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->keterangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Total Capaian</label>
                                <input type="number" name="capaian" id="project-capaian" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Product</label>
                                <input type="number" name="harga" id="product-price" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Total Barang</label>
                                <input required id="total-barang" type="text" class="form-control" name="total_barang" value="{{ old('total_barang') }}" placeholder="Masukkan Total Barang">
                                @error('total_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group"> --}}
                            {{-- <label for="">Harga</label> --}}
                            {{-- <input required type="text" class="form-control" name="harga" value="{{ old('harga') }}" placeholder="Masukkan Harga"> --}}
                            {{-- @error('harga') --}}
                            {{-- <div class="invalid-feedback"> --}}
                            {{-- {{ $message }} --}}
                            {{-- </div> --}}
                            {{-- @enderror --}}
                            {{-- </div> --}}
                            <div class="form-group">
                                <label for="">Diskon</label>
                                <input id="diskon" type="text" class="form-control" name="diskon" value="{{ old('diskon', 0) }}" placeholder="Masukkan diskon">
                                @error('diskon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Total</label>
                                <input required id="total" type="text" class="form-control" name="total" value="{{ old('total') }}" placeholder="Masukkan Total" readonly>
                                @error('total')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Metode Pembayaran</label>
                                {{-- <input required type="text" class="form-control" name="metode_pembayaran" value="{{ old('metode_pembayaran') }}" placeholder="Masukkan Metode Pembayaran"> --}}
                                <select required class="form-control select2" name="metode_pembayaran"
                                    data-placeholder="Pilih Metode Bayar" style="width: 100%;">
                                    <option selected disabled value="">Metode Pembayaran</option>
                                    <option value="tunai">Tunai</option>
                                    <option value="non-tunai">Non Tunai</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Penjualan</label>
                                <input required type="date" class="form-control" name="tgl_penjualan"
                                    value="{{ old('tgl_penjualan') }}" placeholder="Masukkan Tanggal Penjualan">
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
@section('page-script')
    <script>
        $(document).ready(function() {
            $('#project-select').on('change', function() {
                var projectId = $(this).val();

                 $.get('/projects/' + projectId + '/data', function(data) {
                    $('#product-price').val(data.harga);
                    $('#project-capaian').val(data.capaian);
                });
            });

            $('#total-barang, #diskon').on('input', function() {
                var totalBarang = parseInt($('#total-barang').val()) || 0;
                var harga = parseInt($('#product-price').val()) || 0;
                var diskon = parseInt($('#diskon').val()) || 0;

                var total = (totalBarang * harga) - diskon;
                $('#total').val(total);
            });
        });
    </script>
@endsection
