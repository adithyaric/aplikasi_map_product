@extends('layouts.master')

@section('title', 'Edit Lokasi')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Lokasi</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('locations.update', $location->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Lokasi</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name', $location->name) }}" placeholder="Masukkan Nama Lokasi">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tipe Lokasi</label>
                                <select required class="form-control select2" name="type" id="location-type" style="width: 100%;">
                                    <option value="">Pilih Tipe Lokasi</option>
                                    <option value="provinsi" {{ $location->type === 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                    <option value="kabupaten" {{ $location->type === 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                    <option value="kecamatan" {{ $location->type === 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                    <option value="desa" {{ $location->type === 'desa' ? 'selected' : '' }}>Desa</option>
                                    <option value="dusun" {{ $location->type === 'dusun' ? 'selected' : '' }}>Dusun</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group" id="parent-location-group" style="{{ $location->type === 'provinsi' ? 'display: none;' : '' }}">
                                <label for="parent_id">Lokasi Induk</label>
                                <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
                                    <option value="">Pilih Lokasi Induk</option>
                                    @foreach($parentLocations as $parentLocation)
                                        <option value="{{ $parentLocation->id }}" {{ $location->parent_id == $parentLocation->id ? 'selected' : '' }}>
                                            {{ $parentLocation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Koordinat Lokasi</label>
                                    <textarea name="coordinates" class="form-control" id="coordinates" cols="30" rows="10">{{ old('coordinates', $location->coordinates) }}</textarea>
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
    $(document).ready(function () {
        function loadParentLocations(type) {
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
                                $('#parent_id').append(
                                    `<option value="${location.id}" ${location.id == "{{ $location->parent_id }}" ? 'selected' : ''}>${location.name}</option>`
                                );
                            });
                        }
                    });
                }
            }
        }

        // Trigger the function on load to set the initial state for editing
        let initialType = $('#location-type').val();
        loadParentLocations(initialType);

        // Trigger the function when the type is changed
        $('#location-type').on('change', function () {
            loadParentLocations($(this).val());
        });
    });
</script>
@endsection
