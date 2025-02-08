@extends('layouts.master')

@section('title', 'Dashboard')

@section('container')
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <section class="content">
        <div class="row">
            @foreach ($products as $index => $product)
                @php
                    $bgColor = $colors[$index % count($colors)];
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-12">
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
        <div class="row">
            {{-- filter --}}
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body filters">
                        <form id="filterForm" method="GET" action="{{ route('dashboard') }}">
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="text" name="tanggal" placeholder="Pilih Tanggal" id="tanggal"
                                    class="form-control" value="{{ request('tanggal') }}" />

                                <label for="provinsi">Provinsi:</label>
                                <select id="provinsi" name="location_provinsi_id" class="form-control"
                                    style="width: 100%;">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ request('location_provinsi_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="kabupaten">Kabupaten:</label>
                                <select id="kabupaten" name="location_kabupaten_id" class="form-control"
                                    style="width: 100%;" {{ $kabupatens->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Pilih Kabupaten</option>
                                    @foreach ($kabupatens as $kabupaten)
                                        <option value="{{ $kabupaten->id }}"
                                            {{ request('location_kabupaten_id') == $kabupaten->id ? 'selected' : '' }}>
                                            {{ $kabupaten->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="kecamatan">Kecamatan:</label>
                                <select id="kecamatan" name="location_kecamatan_id" class="form-control"
                                    style="width: 100%;" {{ $kecamatans->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}"
                                            {{ request('location_kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="desa">Desa:</label>
                                <select id="desa" name="location_desa_id" class="form-control" style="width: 100%;"
                                    {{ $desas->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Pilih Desa</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa->id }}"
                                            {{ request('location_desa_id') == $desa->id ? 'selected' : '' }}>
                                            {{ $desa->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="dusun">Dusun:</label>
                                <select id="dusun" name="location_dusun_id" class="form-control" style="width: 100%;"
                                    {{ $dusuns->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Pilih Dusun</option>
                                    @foreach ($dusuns as $dusun)
                                        <option value="{{ $dusun->id }}"
                                            {{ request('location_dusun_id') == $dusun->id ? 'selected' : '' }}>
                                            {{ $dusun->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="mt-3 btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
            </div>
            {{-- map --}}
            <div class="col-md-12">
                <div class="box">
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    <style>
                        #map {
                            width: 100%;
                            height: 400px;
                        }
                    </style>
                    <div id="map"></div>

                </div>
            </div>
            {{-- col charts --}}
            <div class="col-md-6">
                <div class="box">
                    <div id="productLocationChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            {{-- pie charts --}}
            <div class="col-md-6">
                <div class="box">
                    <div id="productPieChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            {{-- sales --}}
            <div class="col-md-6">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="examplesales" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Sales</th>
                                    @foreach ($products as $product)
                                        <th>{{ $product->name }}</th>
                                    @endforeach
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- product --}}
            <div class="col-md-6">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="example3" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Product</th>
                                    @foreach ($products as $product)
                                        <th>{{ $product->name }}</th>
                                    @endforeach
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
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

    {{-- <script src="{{ asset('assets/js/charts.js') }}"></script> --}}
    <script src="{{ asset('assets/js/chartflexible.js') }}"></script>
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
