@extends('layouts.user.master')

@section('title', 'Tambah Product')

@section('container')
    <section class="content">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-body">
                    <h2 class="mb-3">History Penyebaran Produk</h2>
                    <table id="example" class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                {{-- <th>Nama Sales (User)</th> --}}
                                <th>Nama Lokasi</th>
                                <th>Nama Produk</th>
                                <th>Banyak Penyebaran (Qty)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locationProducts as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d/M/Y') : '-' }}</td>
                                    {{-- <td>{{ $item->user_name }}</td> --}}
                                    <td>{{ $item->location_name }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- {{ $locationProducts->links() }} --}}
                </div>
            </div>
        </div>
    </section>
@endsection
