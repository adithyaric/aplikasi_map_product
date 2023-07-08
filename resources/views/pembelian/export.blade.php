@extends('layouts.master')

@section('title', 'Pembelian')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Export Pembelian
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form action="{{ route('pembelian.export') }}" method="GET">
                        <div class="form-group">
                            <input type="text" name="tanggal" id="tanggal" class="" value="{{ old('tanggal') }}" />
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
