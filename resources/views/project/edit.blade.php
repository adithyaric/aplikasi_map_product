@extends('layouts.master')

@section('title', 'Edit Project')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Project</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('project.update', $project->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Customer</label>
                                <select required class="form-control select2" name="customer_id"
                                    data-placeholder="Pilih Customer" style="width: 100%;">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id', $project->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Produk Project</label>
                                <select required class="form-control select2" name="product_id"
                                    data-placeholder="Pilih Produk Project" style="width: 100%;">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if ($project->product_id == $product->id) selected @endif>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="number" class="form-control" name="jml_product"
                                    value="{{ old('jml_product', $project->jml_product) }}"
                                    placeholder="Masukkan Jumlah Product">
                                @error('jml_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Durasi</label>
                                {{-- <input required type="text" class="form-control" name="durasi" value="{{ old('durasi', $project->durasi) }}" placeholder="Masukkan Durasi"> --}}
                                <input type="text" name="durasi" id="durasi" class="form-control"
                                    value="{{ old('durasi', $project->durasi) }}" />
                                @error('durasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Hari Toleransi</label>
                                <input type="text" class="form-control datepicker" name="dates"
                                    data-date-format="yyyy-mm-dd">
                                @error('hari_toleransi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input required type="text" class="form-control" name="keterangan"
                                    value="{{ old('keterangan', $project->keterangan) }}"
                                    placeholder="Masukkan keterangan">
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga Project</label>
                                <input required type="text" class="numeral-mask form-control" name="harga"
                                    value="{{ old('harga', $project->harga) }}" placeholder="Masukkan Harga Project">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Untuk Pengecoran</label>
                                <input type="text" class="form-control" name="untuk_pengecoran"
                                    value="{{ old('untuk_pengecoran', $project->untuk_pengecoran) }}">
                                @error('untuk_pengecoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Lokasi Pengecoran</label>
                                <input type="text" class="form-control" name="lokasi_pengecoran"
                                    value="{{ old('lokasi_pengecoran', $project->lokasi_pengecoran) }}">
                                @error('lokasi_pengecoran')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Slump Permintaan</label>
                                <input type="text" class="form-control" name="slump_permintaan"
                                    value="{{ old('slump_permintaan', $project->slump_permintaan) }}">
                                @error('slump_permintaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('project.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@php
    $dates = explode(' - ', $project->durasi);
@endphp
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.numeral-mask').mask("#,##0", {
                reverse: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var startDate = @json($dates[0]);
            var endDate = @json($dates[1]);
            // endDate.setDate(startDate.getDate() + 3);

            $('#durasi').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'YYYY-MM-DD H:mm',
                startDate: startDate,
                endDate: endDate
            });

            $('.datepicker').datepicker({
                daysOfWeekDisabled: [0],
                multidate: true,
                clearBtn: true
            });
        });
    </script>
@endsection
