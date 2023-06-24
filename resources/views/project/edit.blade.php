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
                                <label>Bahan Baku Project</label>
                                <select required class="form-control select2" name="product_id"
                                    data-placeholder="Pilih Bahan Baku Project" style="width: 100%;">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if ($project->product_id == $product->id) selected @endif>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Product</label>
                                <input required type="text" class="form-control" name="jml_product"
                                    value="{{ old('jml_product', $project->jml_product) }}" placeholder="Masukkan Jumlah Product">
                                @error('jml_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Durasi</label>
                                <input required type="text" class="form-control" name="durasi"
                                    value="{{ old('durasi', $project->durasi) }}" placeholder="Masukkan Durasi">
                                @error('durasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Hari Toleransi</label>
                                <input required type="text" class="form-control" name="hari_toleransi"
                                    value="{{ old('hari_toleransi', $project->hari_toleransi) }}" placeholder="Masukkan Hari Toleransi">
                                @error('hari_toleransi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input required type="text" class="form-control" name="keterangan"
                                    value="{{ old('keterangan', $project->keterangan) }}" placeholder="Masukkan keterangan">
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
