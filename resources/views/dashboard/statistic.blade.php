@extends('layouts.master')

@section('title', 'Dashboard')

@section('container')
    <style>
        .active-button {
            background-color: #4CAF50;
            /* Green background for active button */
            color: white;
        }
    </style>
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="mb-4 filters">
                        <label for="provinsi">Provinsi:</label>
                        <select id="provinsi" class="form-control" style="width: 100%;">
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ $loop->first ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>

                        <label for="kabupaten">Kabupaten:</label>
                        <select id="kabupaten" class="form-control" disabled style="width: 100%;">
                            <option value="">Pilih Kabupaten</option>
                        </select>

                        <label for="kecamatan">Kecamatan:</label>
                        <select id="kecamatan" class="form-control" disabled style="width: 100%;">
                            <option value="">Pilih Kecamatan</option>
                        </select>

                        <label for="desa">Desa:</label>
                        <select id="desa" class="form-control" disabled style="width: 100%;">
                            <option value="">Pilih Desa</option>
                        </select>

                        <label for="dusun">Dusun:</label>
                        <select id="dusun" class="form-control" disabled style="width: 100%;">
                            <option value="">Pilih Dusun</option>
                        </select>
                    </div>

                    <!-- Buttons to switch between charts -->
                    <div style="text-align: center; margin-bottom: 10px;margin-top: 10px;">
                        <button id="showLocationChart" class="btn btn-secondary">Show Location Chart</button>
                        <button id="showPieChart" class="btn btn-secondary">Show Pie Chart</button>
                    </div>

                    <!-- Charts -->
                    <div id="productLocationChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    <div id="productPieChart" style="min-width: 310px; height: 400px; margin: 0 auto; display: none;"></div>
                    <div class="box-body table-responsive">
                        <table id="example0" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Product</th>
                                    <th>Banyak Penyebaran (qty)</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
            // By default, show the location chart and hide the pie chart
            $('#productLocationChart').show();
            $('#productPieChart').hide();
            $('#showLocationChart').addClass('active-button');

            // Button to show the location chart
            $('#showLocationChart').click(function() {
                $('#productLocationChart').show();
                $('#productPieChart').hide();
                $(this).addClass('active-button');
                $('#showPieChart').removeClass('active-button');
            });

            // Button to show the pie chart
            $('#showPieChart').click(function() {
                $('#productLocationChart').hide();
                $('#productPieChart').show();
                $(this).addClass('active-button');
                $('#showLocationChart').removeClass('active-button');
            });
        });
    </script>
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
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br />'
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

function updateTable(data) {
    console.log(data);
const tableBody = document.querySelector("#example0 tbody");
tableBody.innerHTML = ''; // Clear the table body before populating

let no = 1;
data.forEach(location => {
Object.entries(location.data).forEach(([product, quantity]) => {
const row = document.createElement('tr');
row.innerHTML = `
<td>${no++}</td>
<td>${product}</td>
<td>${quantity}</td>
`;
tableBody.appendChild(row);
});
});
}
            // Fetch data based on selected location
            function fetchChartData(type, id) {
                fetch(`/chart-data?type=${type}&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        const chartData = data.flatMap(location =>
                            Object.entries(location.data).map(([product, quantity]) => ({
                                name: product,
                                y: quantity,
                                color: location.colors[product] // Assign color from API response
                            }))
                        );
                        updateChart(chartData);
                        updatePieChart(chartData);
                        updateTable(data);
                    });
            }

            let provinsiSelect = document.getElementById("provinsi");
            let firstProvinsi = provinsiSelect.value;

            if (firstProvinsi) {
                fetchChartData("provinsi", firstProvinsi);
                fetchChildLocations("kabupaten", firstProvinsi, "kabupaten");
            }

            // Event listener for dropdown change
            provinsiSelect.addEventListener("change", function() {
                fetchChartData("provinsi", this.value);
                fetchChildLocations("kabupaten", this.value, "kabupaten");
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
