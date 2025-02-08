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
                    <div class="box-body filters">
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

                        <label for="dusun">Tanggal:</label>
                        <input type="text" name="tanggal" placeholder="Pilih Tanggal" id="tanggal" class="form-control" />
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
    <script src="{{ asset('assets/js/charts.js') }}"></script>
@endsection
