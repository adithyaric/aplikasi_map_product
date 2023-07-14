@extends('layouts.master')

@section('title', 'Edit Product')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Product</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{ route('product.update', $product->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            {{-- <div class="form-group"> --}}
                            {{-- <label>Bahan Baku Product</label> --}}
                            {{-- <select required class="form-control select2" name="bahanbaku[]" --}}
                            {{-- data-placeholder="Pilih Bahan Baku Product" style="width: 100%;" multiple> --}}
                            {{-- @foreach ($bahanbakus as $bahanbaku) --}}
                            {{-- <option value="{{ $bahanbaku->id }}" --}}
                            {{-- @foreach ($product->bahanbaku as $value) --}}
                            {{-- @if ($value->id == $bahanbaku->id) --}}
                            {{-- selected --}}
                            {{-- @endif @endforeach> --}}
                            {{-- {{ $bahanbaku->name }} --}}
                            {{-- </option> --}}
                            {{-- @endforeach --}}
                            {{-- </select> --}}
                            {{-- </div> --}}
                            <div class="form-group">
                                <label>Kategori Bahan Baku</label>
                                <select required class="form-control select2" name="category_id"
                                    data-placeholder="Pilih Kategori Bahan Baku" style="width: 100%;">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="forn-group">
                                <div id="bahanbaku-repeater">
                                    @foreach ($product->bahanbaku as $key => $bb)
                                        <div class="form-group">
                                            <label>Bahan Baku Product</label>
                                            <select required class="form-control"
                                                name="bahanbaku[{{ $key }}][bahan_baku_id]"
                                                data-placeholder="Pilih Bahan Baku Product" style="width: 100%;">
                                                @foreach ($bahanbakus as $bahanbaku)
                                                    <option @if ($bb->id == $bahanbaku->id) selected @endif
                                                        value="{{ $bahanbaku->id }}">{{ $bahanbaku->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" required class="form-control"
                                                name="bahanbaku[{{ $key }}][total]"
                                                value="{{ $bb->pivot->total }}">
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" onclick="addBahanBaku()">Add Bahan Baku</button>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="">Nama Product</label>
                                <input required type="text" class="form-control" name="name"
                                    value="{{ old('name', $product->name) }}" placeholder="Masukkan Nama Product">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Harga Product</label>
                                <input required type="text" class="numeral-mask form-control" name="harga"
                                    value="{{ old('harga', $product->harga) }}" placeholder="Masukkan Harga Product">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.numeral-mask').mask("#,##0", {
                reverse: true
            });
        });
    </script>
    <script>
        let bahanbakuIndex = @json($key) + 1;

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
            <input type="text" required class="form-control" name="bahanbaku[${bahanbakuIndex}][total]">
        </div>
    `;
            $('#bahanbaku-repeater').append(bahanbakuTemplate);
        }
    </script>
@endsection
