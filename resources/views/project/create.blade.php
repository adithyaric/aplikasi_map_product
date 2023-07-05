@extends('layouts.master')

@section('title', 'Tambah Project')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Project</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('project.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
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
                                <label>Produk Project</label>
                                <select required class="form-control select2" name="product_id" data-placeholder="Pilih Produk Project"
                                    style="width: 100%;">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="number" class="form-control" name="jml_product"
                                    value="{{ old('jml_product') }}" placeholder="Masukkan Jumlah Product">
                                @error('jml_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Durasi</label>
                                {{-- <input required type="text" class="form-control" name="durasi" value="{{ old('durasi') }}" placeholder="Masukkan Durasi"> --}}
                                <input type="text" name="durasi" id="durasi" class="form-control" value="{{ old('durasi') }}" />
                                @error('durasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Hari Toleransi</label>
                                {{-- <input required type="text" class="form-control" name="hari_toleransi" value="{{ old('hari_toleransi') }}" placeholder="Masukkan Hari Toleransi"> --}}
                                <input type="text" class="form-control datepicker" name="dates" data-date-format="yyyy-mm-dd">
                                @error('hari_toleransi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input required type="text" class="form-control" name="keterangan"
                                    value="{{ old('keterangan') }}" placeholder="Masukkan keterangan">
                                @error('keterangan')
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
@section('page-script')
    <script>
        $(document).ready(function() {
            var startDate = new Date();
            var endDate = new Date();
            endDate.setDate(startDate.getDate() + 3);

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
