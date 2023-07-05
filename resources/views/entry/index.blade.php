@extends('layouts.master')

@section('title', 'Project')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Project
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Kustomer</td>
                                    <td>Nama Product</td>
                                    <td>Jumlah Product</td>
                                    <td>Durasi</td>
                                    <td>Keterangan</td>
                                    <td>Banyak Capaian</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            @foreach ($projects as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td></td>
                                    <td>{{ $value->product->name }}</td>
                                    <td>{{ $value->jml_product }}</td>
                                    <td>
                                        @php
                                            $dates = explode(' - ', $value->durasi);
                                            $start_date = \Carbon\Carbon::parse($dates[0])->format('d-m-Y');
                                            $end_date = \Carbon\Carbon::parse($dates[1])->format('d-m-Y');
                                        @endphp

                                        {{ $start_date }} - {{ $end_date }}
                                    </td>
                                    <td>{{ $value->keterangan }}</td>
                                    <td>{{ $value->entries->sum('capaian') }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('entry.create', ['project_id' => $value->id]) }}">Input</a>
                                        <a class="btn btn-info" href="{{ route('entry.show', $value->id) }}">Show</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection
