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
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div id="chart"></div>
                    </div><!-- /.box-body -->
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
                    chart = new Highcharts.chart('chart', {
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
                            data: targets
                        }]
                    });
                }
            });
        });
    </script>
@endsection
