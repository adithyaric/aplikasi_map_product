@extends('layouts.master')

@section('title', 'Project')

@section('container')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Export Project
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!--Modals Satu-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-print"></i> Project Report</button>
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Purchase Report</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <p>Pilih Tanggal Untuk Mencetak Laporan</p>
                            
                            <form action="{{ route('project.export') }}" method="GET">
                        <div class="form-group">
                            <input placeholder="Pilih Tanggal" type="text" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" />
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
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Customer</td>
                                    <td>Nama Product</td>
                                    <td>Jumlah Product</td>
                                    <td>Durasi</td>
                                    <td>Keterangan</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            @foreach ($projects as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->customer->name }}</td>
                                    <td>{{ $value->product->name }}</td>
                                    <td>{{ $value->jml_product }}</td>
                                    <td>
                                        @php
                                            $dates = explode(' - ', $value->durasi);
                                            $start_date = \Carbon\Carbon::parse($dates[0])->format('d-m-Y');
                                            $end_date = \Carbon\Carbon::parse($dates[1])->format('d-m-Y');
                                        @endphp

                                        {{ $start_date }} - {{ $end_date }}
                                    </td>
                                    <td>{{ $value->keterangan }}</td>
                                    <td>
                                            <button
                                                class="border-0 btn btn-{{ $value->status === 'proses' ? 'primary' : 'success' }}"
                                                type="submit">{{ $value->status }}</button>
                                    </td>
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
