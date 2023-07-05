@extends('layouts.master')

@section('title', 'Tambah Product')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Product</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="box-body">
                            {{-- <div class="form-group"> --}}
                                {{-- <label>Bahan Baku Product</label> --}}
                                {{-- <select required class="form-control" name="bahanbaku[]" --}}
                                    {{-- data-placeholder="Pilih Bahan Baku Product" style="width: 100%;" multiple> --}}
                                    {{-- @foreach ($bahanbakus as $bahanbaku) --}}
                                        {{-- <option value="{{ $bahanbaku->id }}">{{ $bahanbaku->name }} --}}
                                        {{-- </option> --}}
                                    {{-- @endforeach --}}
                                {{-- </select> --}}
                            {{-- </div> --}}
                            <hr>
                            <div class="forn-group">
                                <div id="bahanbaku-repeater">
                                    <div class="form-group">
                                        <label>Bahan Baku Product</label>
                                        <select required class="form-control" name="bahanbaku[0][bahan_baku_id]"
                                            data-placeholder="Pilih Bahan Baku Product" style="width: 100%;">
                                            @foreach ($bahanbakus as $bahanbaku)
                                                <option value="{{ $bahanbaku->id }}">{{ $bahanbaku->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Total</label>
                                        <input type="number" required class="form-control" name="bahanbaku[0][total]">
                                    </div>
                                </div>

                                <button type="button" onclick="addBahanBaku()">Add Bahan Baku</button>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="">Nama Product</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="Masukkan Nama Product">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga Product</label>
                                <input required type="text" class="form-control" name="harga"
                                    value="{{ old('harga') }}" placeholder="Masukkan Harga Product">
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('product.index') }}" class="btn btn-default">Kembali</a>
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
let bahanbakuIndex = 0;

function addBahanBaku() {
    bahanbakuIndex++;
    let bahanbakuTemplate = `
        <div class="form-group">
            <label>Bahan Baku Product</label>
            <select required class="form-control" name="bahanbaku[${bahanbakuIndex}][bahan_baku_id]"
                data-placeholder="Pilih Bahan Baku Product" style="width: 100%;">
                @foreach ($bahanbakus as $bahanbaku)
                    <option value="{{ $bahanbaku->id }}">{{ $bahanbaku->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Total</label>
            <input type="number" required class="form-control" name="bahanbaku[${bahanbakuIndex}][total]">
        </div>
    `;
    $('#bahanbaku-repeater').append(bahanbakuTemplate);
}
    </script>
@endsection
