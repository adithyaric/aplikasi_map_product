@extends('layouts.master')

@section('title', 'Edit Product Penyebaran')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                        <h3>Edit Penyebaran Produk</h3>
                        <form action="{{ route('product.update', $locationProduct->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="date" class="form-control" name="date"
                                    value="{{ $locationProduct->date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Jumlah</label>
                                <input type="number" class="form-control" name="quantity"
                                    value="{{ $locationProduct->quantity }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('product.input.history') }}" class="btn btn-secondary">Batal</a>
                        </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
