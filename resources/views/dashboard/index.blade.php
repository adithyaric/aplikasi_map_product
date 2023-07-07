@extends('layouts.master')

@section('title', 'Dashboard')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach ($projects as $project)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="small-box bg-gradient-blue">
                                <div class="inner">
                                    <h3>{{ $project->targets->sum('target') }}</h3>
                                    <p>Target Project {{ $project->keterangan }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pie-chart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="small-box bg-gradient-teal">
                                <div class="inner">
                                    <h3>{{ $project->entries->sum('capaian') }}</h3>
                                    <p>Capaian Project {{ $project->keterangan }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pie-chart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="small-box bg-gradient-yellow">
                                <div class="inner">
                                    @php
                                        $pengirimanCount = 0;
                                    @endphp
                                    @foreach ($project->penjualan as $penjualan)
                                        @php
                                            $pengirimanCount += $penjualan->pengiriman->count();
                                        @endphp
                                    @endforeach
                                    <h3>{{ $pengirimanCount }}</h3>
                                    <p>Project Dikirim</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pie-chart"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
@endsection
