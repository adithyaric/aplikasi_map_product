@extends('layouts.master')

@section('title', 'Edit Pengiriman')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Pengiriman</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('pengiriman.update', $pengiriman->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Customer</label>
                                <select required class="form-control select2" name="customer_id"
                                    data-placeholder="Pilih Customer" style="width: 100%;">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id', $pengiriman->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
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
                                            {{ old('driver_id', $pengiriman->driver_id) == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Project</label>
                                <select required class="form-control select2" name="project_id"
                                    data-placeholder="Pilih Project" style="width: 100%;">
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id', $pengiriman->project_id) == $project->id ? 'selected' : '' }}>
                                            {{ $project->keterangan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="text" class="form-control" name="jml_product"
                                    value="{{ old('jml_product', $pengiriman->jml_product) }}" placeholder="Masukkan Jumlah Product">
                                @error('jml_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pengiriman</label>
                                <input required type="date" class="form-control" name="tgl_pengiriman"
                                    value="{{ old('tgl_pengiriman', $pengiriman->tgl_pengiriman) }}" placeholder="Masukkan Tanggal Pengiriman">
                                @error('tgl_pengiriman')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Jam</label>
                                <input required type="time" class="form-control" name="jam"
                                    value="{{ old('jam', $pengiriman->jam) }}" placeholder="Masukkan Jam">
                                @error('jam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
