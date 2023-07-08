@extends('layouts.master')

@section('title', 'Pengiriman')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Pengiriman
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form action="{{ route('pengiriman.export') }}" method="GET">
                        <div class="form-group">
                            <label for="">Export Pengiriman</label>
                            <input type="text" name="tanggal" id="tanggal" class="form-input"
                                value="{{ old('tanggal') }}" />
                            <button class="btn btn-primary" type="submit">Export</button>
                        </div>
                    </form>
                    <form action="{{ route('pengiriman.daily') }}" method="GET">
                        <div class="form-group">
                            <label for="">Pengiriman Daily</label>
                            <input type="date" name="tanggal" class="form-input" value="{{ old('tanggal') }}" />
                            <button class="btn btn-primary" type="submit">Export</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
@endsection
@section('page-script')
    <script>
        $(document).ready(function() {
            var startDate = new Date();
            var endDate = new Date();

            $('#tanggal').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'YYYY-MM-DD H:mm',
                startDate: startDate,
                endDate: endDate
            });
        });
    </script>
@endsection
