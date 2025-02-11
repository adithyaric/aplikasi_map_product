@extends('layouts.master')

@section('title', 'Laporan')

@section('container')
    <section class="content-header">
        <h1>Laporan</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body filters">
                        <form id="filterForm" method="GET" action="{{ route('export.data') }}">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="tanggal">Tanggal:</label>
                                    <input type="text" name="tanggal" placeholder="Pilih Tanggal" id="tanggal"
                                        class="form-control" value="{{ request('tanggal') }}" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection
@section('page-script')
    <script>
        // Set startDate to the first day of the current month
        var startDate = new Date(
            new Date().getFullYear(),
            new Date().getMonth(),
            1
        );

        // Set endDate to the last day of the current month
        var endDate = new Date(
            new Date().getFullYear(),
            new Date().getMonth() + 1,
            0
        );

        $("#tanggal").daterangepicker({
            format: "YYYY-MM-DD",
            startDate: startDate,
            endDate: endDate,
        });

        $("#tanggal").on("change", function() {
            var dateRange = $(this).val();
            var [start, end] = dateRange.split(" - ");
        });
    </script>
@endsection
