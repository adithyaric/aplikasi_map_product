@extends('layouts.master')

@section('title', 'Tambah Product')

@section('container')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <h2 class="mb-3">Pengajuan</h2>
                        <table id="example3" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal Request</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requestInputs as $request)
                                    <tr>
                                        <td>{{ $request->user->name }}</td>
                                        <td>{{ $request->location->name }}</td>
                                        <td>{{ $request->requested_at }}</td>
                                        <td>{{ ucfirst($request->status) }}</td>
                                        <td>
                                            @if ($request->status === 'waiting')
                                                <form action="{{ route('request.input.approve', $request->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $locationProducts->links() }} --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <h2 class="mb-3">History Penyebaran Produk</h2>
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Sales (User)</th>
                                <th>Nama Lokasi</th>
                                <th>Nama Produk</th>
                                <th>Banyak Penyebaran (Qty)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locationProducts as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d/M/Y') : '-' }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->location_name }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('product.edit', $item->id) }}">Edit</a>
                                    </td>
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
