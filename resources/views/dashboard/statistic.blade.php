@extends('layouts.master')

@section('title', 'Statistik')

@section('container')
    <style>
        .active-button {
            background-color: #4CAF50;
            /* Green background for active button */
            color: white;
        }
    </style>
    <section class="content-header">
        <h1>Statistik</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body filters">
                        <form id="filterForm" method="GET" action="{{ route('dashboard.statistik') }}">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="tanggal">Tanggal:</label>
                                    <input type="text" name="tanggal" placeholder="Pilih Tanggal" id="tanggal"
                                        class="form-control" value="{{ request('tanggal') }}" />
                                </div>
                                <div class="col-md-6 form-group">
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
                                </div>
                                <div class="col-md-6 form-group">
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
                                </div>
                                <div class="col-md-6 form-group">
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
                                </div>

                                <div class="col-md-6 form-group">
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
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="dusun">Dusun:</label>
                                    <select id="dusun" name="location_dusun_id" class="form-control"
                                        style="width: 100%;" {{ $dusuns->isEmpty() ? 'disabled' : '' }}>
                                        <option value="">Pilih Dusun</option>
                                        @foreach ($dusuns as $dusun)
                                            <option value="{{ $dusun->id }}"
                                                {{ request('location_dusun_id') == $dusun->id ? 'selected' : '' }}>
                                                {{ $dusun->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
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
    {{-- <script src="{{ asset('assets/js/charts.js') }}"></script> --}}
    <script src="{{ asset('assets/js/chartflexible.js') }}"></script>
@endsection
