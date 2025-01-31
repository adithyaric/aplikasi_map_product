@extends('layouts.master')

@section('title', 'Dashboard')

@section('container')
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @foreach ($products as $index => $product)
                    @php
                        $bgColor = $colors[$index % count($colors)];
                    @endphp
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="small-box" style="background-color: {{ $bgColor }};">
                            <div class="inner">
                                <h3>{{ $product->locations->sum('pivot.quantity') }}</h3>
                                <p>{{ $product->name }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-pie-chart"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-xs-6">
                <div class="box">
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <style>
                        #map {
                            width: 100%;
                            height: 295px;
                        }
                    </style>
                    <div id="map"></div>

                </div>
            </div>
            <div class="col-xs-6">
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
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-xs-6">
                <div class="box">
                    <div id="productLocationChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="box">
                    <div id="productPieChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
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
                        console.log(chartData);
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

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-7.656172633765166, 111.32830621325536], 9.11);

        // Add a base map layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://decaa.idt">DECAA.ID</a> X OSM contributors'
        }).addTo(map);

        // Maps data from the backend
        const maps = @json($data);
        console.log("Maps Data:", maps);

        // Iterate through maps and create polygons
        maps.forEach(peta => {
            console.log("Popup Data for:", peta.name, peta.data); // Debugging

            const polygon = L.polygon(peta.coordinates.map(coord => [coord[1], coord[0]]), {
                color: peta.color,
            }).addTo(map);

            // Bind popup with location name and product percentages
            polygon.bindPopup(`
                <b>${peta.name || 'Unknown'}</b><br>
                ${peta.data && Object.keys(peta.data).length
                    ? Object.entries(peta.data)
                        .map(([product, percentage]) => `${product}: ${percentage}`)
                        .join('<br>')
                    : 'No product data available'}
                <br>
                <a href="${peta.nextRoute}">View Detail</a>
            `);
        });
    </script>
@endsection
