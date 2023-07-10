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
                <div class="box-header">
                    <!--Modals Satu-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-print"></i> Delivery Report</button>
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Delivery Report</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <p>Pilih Tanggal Untuk Mencetak Laporan</p>
                            
                            <form action="{{ route('pengiriman.export') }}" method="GET">
                                    <div class="form-group">
                                        <!--<label  for="">Delivery Report</label>-->
                                        <input type="text" name="tanggal" placeholder="Pilih Tanggal" id="tanggal" class="form-control"
                                            value="{{ old('tanggal') }}" />
                                    </div>
                          </div>
                          <div class="modal-footer">
                              <button class="btn btn-primary" type="submit">Export</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--End Modal Satu-->
                    
                    <!--Modals Dua-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal1"><i class="fa fa-print"></i> Daily Report</button>
                    <div id="myModal1" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Daily Report</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <p>Pilih Tanggal Untuk Mencetak Laporan</p>
                                <form action="{{ route('pengiriman.daily') }}" method="GET">
                                    <div class="form-group">
                                        <input type="date" placeholder="Pilih Tanggal" name="tanggal" class="form-control" value="{{ old('tanggal') }}" />
                                    </div>
                          </div>
                          <div class="modal-footer">
                              <button class="btn btn-primary" type="submit">Export</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--End Modal Dua-->            
                </div> <!--box-header-->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>No Order Penjualan</td>
                                    <td>Nama Driver</td>
                                    <td>Solar</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            @foreach ($pengirimans as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->penjualan->no_invoice }}</td>
                                    <td>{{ $value->driver->name }}</td>
                                    <td>{{ $value->solar ?? '0' }} L</td>
                                    <td>{{ strtoupper($value->status) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div><!-- /.box-body -->
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
