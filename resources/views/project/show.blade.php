@extends('layouts.master')

@section('title', 'Project')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Chart Project
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                        <tr>
                            <th>Nama Customer</th>
                            <td>{{ $project->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td>{{ $project->product->name }} ({{ $project->product->category->name }})</td>
                        </tr>
                        <tr>
                            <th>Harga Project</th>
                            <td>{{ $project->harga }}</td>
                        </tr>
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
                            <th>Total Capaian</th>
                            <td colspan="3">{{ $project->entries->sum('capaian') }}</td>
                        </tr>
                        <tr>
                            <th>Produk Terkirim</th>
                            <td colspan="3">
                                {{ $project->penjualan->sum('total_barang') }}
                            </td>
                        </tr>
                        <!--<tr>-->
                        <!--    <th>Produk Tersisa</th>-->
                        <!--    <td colspan="3">-->
                        <!--        {{ $project->entries->sum('capaian') - $project->penjualan->sum('total_barang') }}-->
                        <!--    </td>-->
                        <!--</tr>-->
                    </table>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="chartTarget"></div>
                        {{-- <div id="chartCapaian"></div> --}}
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('project.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/exporting.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/export-data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/accessibility.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('getTarget') }}?' + "project_id=" + @json($project->id),
                type: 'get',
                success: function(res) {
                    var days = res.map(function(day) {
                        return day.day;
                    });
                    var targets = res.map(function(day) {
                        return day.target;
                    });
                    chart = new Highcharts.chart('chartTarget', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Target Per Hari'
                        },
                        xAxis: {
                            categories: days
                        },
                        yAxis: {
                            allowDecimals: false,
                            min: 0,
                            title: {
                                text: 'Target'
                            }
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                }
                            },
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    formatter: function() {
                                        return Highcharts.numberFormat(this.y);
                                    }
                                }
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>' + this.x + '</b><br/>' + this.series.name +
                                    ': ' + this.y;
                            }
                        },
                        series: [{
                            name: 'Hari',
                            color: '#f52288',
                            data: targets.map(Number)
                        }]
                    });
                }
            });

            $.ajax({
                url: '{{ route('getCapaian') }}?' + "project_id=" + @json($project->id),
                type: 'get',
                success: function(res) {
                    var days = res.map(function(day) {
                        return day.day;
                    });
                    var targets = res.map(function(day) {
                        return day.capaian;
                    });
                    chart = new Highcharts.chart('chartCapaian', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Target Per Hari'
                        },
                        xAxis: {
                            categories: days
                        },
                        yAxis: {
                            allowDecimals: false,
                            min: 0,
                            title: {
                                text: 'Target'
                            }
                        },
                        plotOptions: {
                            column: {
                                dataLabels: {
                                    enabled: true
                                }
                            },
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    formatter: function() {
                                        return Highcharts.numberFormat(this.y);
                                    }
                                }
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>' + this.x + '</b><br/>' + this.series.name +
                                    ': ' + this.y;
                            }
                        },
                        series: [{
                            name: 'Hari',
                            colorByPoint: true,
                            data: targets.map(Number)
                        }]
                    });
                }
            });
        });
    </script>
@endsection
