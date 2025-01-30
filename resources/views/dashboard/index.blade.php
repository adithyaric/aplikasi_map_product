@extends('layouts.master')

@section('title', 'Dashboard')

@section('container')
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="mb-4 filters">
                        <label for="provinsi">Provinsi:</label>
                        <select id="provinsi" class="form-control">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>

                        <label for="kabupaten">Kabupaten:</label>
                        <select id="kabupaten" class="form-control" disabled>
                            <option value="">Pilih Kabupaten</option>
                        </select>

                        <label for="kecamatan">Kecamatan:</label>
                        <select id="kecamatan" class="form-control" disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>

                        <label for="desa">Desa:</label>
                        <select id="desa" class="form-control" disabled>
                            <option value="">Pilih Desa</option>
                        </select>

                        <label for="dusun">Dusun:</label>
                        <select id="dusun" class="form-control" disabled>
                            <option value="">Pilih Dusun</option>
                        </select>
                    </div>

                    <div id="productLocationChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    <div id="productPieChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const chartElement = document.getElementById('productLocationChart');
            const pieChartElement = document.getElementById('productPieChart');
            let chart, pieChart;

            // Initialize the column chart
            function initChart(data) {
                chart = Highcharts.chart(chartElement, {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Product Quantities by Location'
                    },
                    xAxis: {
                        type: 'category',
                        title: {
                            text: 'Products'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Quantity'
                        }
                    },
                    series: [{
                        name: 'Quantity',
                        data: data
                    }],
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: true,
                                format: '{y}'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                    }
                });
            }

            // Initialize the pie chart
            function initPieChart(data) {
                pieChart = Highcharts.chart(pieChartElement, {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Product Distribution'
                    },
                    series: [{
                        name: 'Quantity',
                        data: data
                    }],
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.2f}%)'
                            }
                        }
                    },
                    tooltip: {
                        pointFormat: '<b>{point.y}</b>'
                    }
                });
            }

            // Update the column chart with new data
            function updateChart(data) {
                if (chart) {
                    chart.series[0].setData(data);
                } else {
                    initChart(data);
                }
            }

            // Update the pie chart with new data
            function updatePieChart(data) {
                if (pieChart) {
                    pieChart.series[0].setData(data);
                } else {
                    initPieChart(data);
                }
            }

            // Fetch data based on selected location
            function fetchChartData(type, id) {
                fetch(`/chart-data?type=${type}&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const chartData = data.flatMap(location =>
                            Object.entries(location.data).map(([product, quantity]) => ({
                                name: product,
                                y: quantity
                            }))
                        );
                        updateChart(chartData);
                        updatePieChart(chartData);
                    });
            }

            // Event listeners for filters
            document.getElementById('provinsi').addEventListener('change', function() {
                const provinsiId = this.value;
                fetchChartData('provinsi', provinsiId);
                fetchChildLocations('kabupaten', provinsiId, 'kabupaten');
            });

            document.getElementById('kabupaten').addEventListener('change', function() {
                const kabupatenId = this.value;
                fetchChartData('kabupaten', kabupatenId);
                fetchChildLocations('kecamatan', kabupatenId, 'kecamatan');
            });

            document.getElementById('kecamatan').addEventListener('change', function() {
                const kecamatanId = this.value;
                fetchChartData('kecamatan', kecamatanId);
                fetchChildLocations('desa', kecamatanId, 'desa');
            });

            document.getElementById('desa').addEventListener('change', function() {
                const desaId = this.value;
                fetchChartData('desa', desaId);
                fetchChildLocations('dusun', desaId, 'dusun');
            });

            document.getElementById('dusun').addEventListener('change', function() {
                const dusunId = this.value;
                fetchChartData('dusun', dusunId);
            });

            // Fetch child locations dynamically
            function fetchChildLocations(type, parentId, targetSelectId) {
                fetch(`/child-locations/${type}/${parentId}`)
                    .then(response => response.json())
                    .then(data => {
                        const targetSelect = document.getElementById(targetSelectId);
                        targetSelect.innerHTML = '<option value="">Pilih ' + type.charAt(0).toUpperCase() + type
                            .slice(1) + '</option>';
                        data.forEach(location => {
                            const option = document.createElement('option');
                            option.value = location.id;
                            option.textContent = location.name;
                            targetSelect.appendChild(option);
                        });
                        targetSelect.disabled = false;
                    });
            }
        });
    </script>
@endsection
