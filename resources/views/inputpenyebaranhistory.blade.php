@extends('layouts.master')

@section('title', 'Tambah Product')

@section('container')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <h2 class="mb-3">History Penyebaran Produk</h2>
                    <table id="example1" class="table table-bordered">
                        <thead class="thead-dark">
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
                                            <form action="{{ route('request.input.approve', $request->id) }}" method="POST">
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
    </section>
@endsection
