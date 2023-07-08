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
                <div class="row">
                    <!--card-pills-->
                    @foreach ($projects as $project)
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="small-box bg-green-gradient">
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
                            <div class="small-box bg-teal-gradient">
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
                            <div class="small-box bg-yellow-gradient">
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

                <div class="row">
                    <!--Grafik-->
                    @foreach ($projects as $project)
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <label for="">{{ $project->keterangan }}</label>
                                <div id="chartCapaian{{ $project->id }}" data-project-id="{{ $project->id }}"></div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    @endforeach
            </div>
    </section><!-- /.content -->
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/highcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/exporting.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/export-data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/accessibility.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[id^=chartCapaian]').each(function() {
                var projectId = $(this).data('project-id');
                $.ajax({
                    url: '{{ route('getCapaian') }}?' + "project_id=" + projectId,
                    type: 'get',
                    success: function(res) {
                        var days = res.map(function(day) {
                            return day.day;
                        });
                        var targets = res.map(function(day) {
                            return day.target;
                        });
                        var entries = res.map(function(day) {
                            return day.capaian;
                        });
                        chart = new Highcharts.chart('chartCapaian' + projectId, {
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
                                    return '<b>' + this.x + '</b><br/>' + this
                                        .series.name +
                                        ': ' + this.y;
                                }
                            },
                            series: [{
                                name: 'Targets',
                                color: '#f52288',
                                data: targets.map(Number)
                            }, {
                                name: 'Capaian',
                                color: '#22f5a8',
                                data: entries.map(Number)
                            }]
                        });
                    }
                });
            });

        });
    </script>
@endsection
