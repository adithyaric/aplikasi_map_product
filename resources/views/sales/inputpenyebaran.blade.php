@extends('layouts.user.master')
{{-- @extends('layouts.master') --}}

@section('title', 'Input Penyebaran Product')

@section('container')
    <section class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <!-- left column -->
            <div class="card col-md-12">
                <div class="card-body">
                    <h1>Input Penyebaran Product</h1>
                    <form action="{{ route('request.input.store') }}" method="POST">
                        @csrf
                        <div class="form-group" style="display: none;">
                            <label for="user_id">Pilih User</label>
                            <select name="user_id" id="user_id" class="form-control select2" required style="width: 100%;">
                                <option value="" disabled selected>-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Desa Dropdown (Dependent on User) -->
                        <div class="form-group">
                            <label for="desa_id">Pilih Desa</label>
                            <select name="desa_id" id="desa_id" class="form-control select2" required disabled>
                                <option value="" disabled selected>-- Pilih Desa --</option>
                            </select>
                        </div>

                        <!-- Dusun Dropdown (Dependent on Desa) -->
                        <div class="form-group">
                            <label for="dusun_id">Pilih Dusun</label>
                            <select name="location_id" id="dusun_id" class="form-control select2" required disabled>
                                <option value="" disabled selected>-- Pilih Dusun --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            @foreach ($products as $product)
                                <div class="form-group">
                                    <label>{{ $product->name }}</label>
                                    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                                    <input type="number" name="quantity[]" class="form-control"
                                        value="{{ old('quantity.' . $loop->index) }}" placeholder="Masukkan Jumlah"
                                        required>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="created_at">Tanggal</label>
                            <input type="date" name="created_at" id="created_at" class="form-control"
                                value="{{ old('created_at') }}" required>
                            @error('created_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 form-footer">
                            <a href="{{ route('dashboard') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.card -->
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            let userSelect = document.getElementById("user_id");
            let firstUserOption = userSelect.options[1];

            if (firstUserOption) {
                userSelect.value = firstUserOption.value;
                // $('#user_id').trigger('change');
                let userId = firstUserOption.value;
                $('#desa_id').html('<option value="" disabled selected>Loading...</option>').prop(
                    'disabled', true);
                $('#dusun_id').html('<option value="" disabled selected>-- Pilih Dusun --</option>').prop(
                    'disabled', true);

                $.get('/get-desa/' + userId, function(data) {
                    let options = '<option value="" disabled selected>-- Pilih Desa --</option>';
                    data.forEach(function(desa) {
                        options += `<option value="${desa.id}">${desa.name}</option>`;
                    });
                    $('#desa_id').html(options).prop('disabled', false);
                });
            }
            // $('#user_id').change(function() {
            //     let userId = $(this).val();
            //     $('#desa_id').html('<option value="" disabled selected>Loading...</option>').prop(
            //         'disabled', true);
            //     $('#dusun_id').html('<option value="" disabled selected>-- Pilih Dusun --</option>').prop(
            //         'disabled', true);

            //     $.get('/get-desa/' + userId, function(data) {
            //         let options = '<option value="" disabled selected>-- Pilih Desa --</option>';
            //         data.forEach(function(desa) {
            //             options += `<option value="${desa.id}">${desa.name}</option>`;
            //         });
            //         $('#desa_id').html(options).prop('disabled', false);
            //     });
            // });

            $('#desa_id').change(function() {
                let desaId = $(this).val();
                $('#dusun_id').html('<option value="" disabled selected>Loading...</option>').prop(
                    'disabled', true);

                $.get('/get-dusun/' + desaId, function(data) {
                    let options = '<option value="" disabled selected>-- Pilih Dusun --</option>';
                    data.forEach(function(dusun) {
                        options += `<option value="${dusun.id}">${dusun.name}</option>`;
                    });
                    $('#dusun_id').html(options).prop('disabled', false);
                });
            });
        });
    </script>
@endsection
