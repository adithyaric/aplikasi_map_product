@extends('layouts.master')

@section('title', 'Tambah Product')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <h1>Input Penyebaran Product</h1>
                    <form action="{{ route('product.input.quantity') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Pilih User</label>
                            <select name="user_id" id="user_id" class="form-control select2" required style="width: 100%;">
                                <option value="" disabled selected>-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location_id">Pilih Lokasi</label>
                            <select name="location_id" id="location_id" class="form-control select2" required style="width: 100%;">
                                <option value="" disabled selected>-- Pilih Lokasi --</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_id">Pilih Produk</label>
                            <select name="product_id" id="product_id" class="form-control select2" required style="width: 100%;">
                                <option value="" disabled selected>-- Pilih Produk --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="quantity">Jumlah</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                value="{{ old('quantity') }}" placeholder="Masukkan Jumlah" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Uncomment this if you need to include a date input --}}
                        {{-- <div class="form-group"> --}}
                        {{-- <label for="date">Tanggal</label> --}}
                        {{-- <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required> --}}
                        {{-- @error('date') --}}
                        {{-- <div class="invalid-feedback"> --}}
                        {{-- {{ $message }} --}}
                        {{-- </div> --}}
                        {{-- @enderror --}}
                        {{-- </div> --}}

                        <div class="mt-3 form-footer">
                            <a href="{{ route('product.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
