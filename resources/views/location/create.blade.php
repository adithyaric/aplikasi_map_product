@extends('layouts.master')

@section('title', 'Tambah Lokasi')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Lokasi</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('locations.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Nama Lokasi</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Lokasi">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tipe Lokasi</label>
                                <select required class="form-control select2" name="type" id="location-type" style="width: 100%;">
                                    <option value="">Pilih Tipe Lokasi</option>
                                    <option value="provinsi">Provinsi</option>
                                    <option value="kabupaten">Kabupaten</option>
                                    <option value="kecamatan">Kecamatan</option>
                                    <option value="desa">Desa</option>
                                    <option value="dusun">Dusun</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" id="parent-location-group" style="display: none;">
                                <label for="parent_id">Lokasi Induk</label>
                                <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
                                    <!-- Options will be populated dynamically -->
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Koordinat Lokasi</label>
                                <textarea class="form-control" name="coordinates" id="" cols="30" rows="10">{{ old('coordinates') }}</textarea>
                                @error('coordinates')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('locations.index') }}" class="btn btn-default">Kembali</a>
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
    $('#location-type').on('change', function () {
        let type = $(this).val();
        if (type === 'provinsi') {
            $('#parent-location-group').hide();
        } else {
            $('#parent-location-group').show();
            let parentType = {
                kabupaten: 'provinsi',
                kecamatan: 'kabupaten',
                desa: 'kecamatan',
                dusun: 'desa'
            }[type] || '';
            if (parentType) {
                $.ajax({
                    url: "{{ route('locations.getParents') }}",
                    type: "GET",
                    data: { type: parentType },
                    success: function (response) {
                        $('#parent_id').empty().append('<option value="">Pilih Lokasi Induk</option>');
                        response.forEach(function (location) {
                            $('#parent_id').append(`<option value="${location.id}">${location.name}</option>`);
                        });
                    }
                });
            }
        }
    });
</script>
@endsection
