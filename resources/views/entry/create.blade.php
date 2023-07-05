@extends('layouts.master')

@section('title', 'Tambah Entry')

@section('container')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Entry</h3>
                    </div><!-- /.box-header -->
                    <table id="example1" class="table table-bordered table-striped">
                        <tr>
                            <th>Durasi</th>
                            <td>
                                @php
                                    $dates = explode(' - ', $project->durasi);
                                    $start_date = \Carbon\Carbon::parse($dates[0])->format('d-m-Y');
                                    $end_date = \Carbon\Carbon::parse($dates[1])->format('d-m-Y');
                                @endphp

                                {{ $start_date }} - {{ $end_date }}
                            </td>
                        </tr>
                        <tr>
                            <th>Banyak Hari Toleransi</th>
                            <td>{{ count(json_decode($project->hari_toleransi)) }}</td>
                        </tr>
                        <tr>
                            <th>Target Keseluruhan</th>
                            <td>{{ $project->jml_product }}</td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Banyak Capaian</th>
                            <th>Aksi</th>
                        </tr>
                        @foreach ($project->entries->sortBy('day') as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>
                                    {{ \Carbon\Carbon::parse($value->day)->format('d-m-Y') }}
                                </th>
                                <td>
                                    {{ $value->capaian }}
                                </td>
                                <td>
                                    <form action="{{ route('entry.destroy', $value->id) }}" method="post"
                                        style="display: inline;">
                                        @method('delete')
                                        @csrf
                                        <button class="border-0 btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="2">Total</th>
                            <td>{{ $project->entries->sum('capaian') }}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Produk Tersisa</th>
                            <td>
                                {{ $project->entries->sum('capaian') - $project->penjualan->sum('total_barang') }}
                            </td>
                        </tr>
                    </table>

                    <!-- form start -->
                    <form action="{{ route('entry.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input required type="date" class="form-control" name="tanggal"
                                    value="{{ old('tanggal') }}" placeholder="Masukkan Tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Capaian</label>
                                <input required type="text" class="form-control" name="capaian"
                                    value="{{ old('capaian') }}" placeholder="Masukkan Capaian">
                                @error('capaian')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{ route('entry.index') }}" class="btn btn-default">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
