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
                    <!--Modals Satu-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-print"></i>
                        Purchase Report
                    </button>
                    <button class="btn btn-success" data-toggle="modal" data-target="#myModalFilter">
                        <i class="fa fa-print"></i>
                        Purchase Report Filter By Supplier
                    </button>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Purchase Report</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form action="{{ route('pembelian.export') }}" method="GET">
                                    <div class="modal-body">
                                        <p>Pilih Tanggal Untuk Mencetak Laporan</p>
                                        <div class="form-group">
                                            <input type="text" placeholder="Pilih Tanggal" name="tanggal" id="tanggal"
                                                class="form-control tanggal" value="{{ old('tanggal') }}" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Export</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="myModalFilter" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Purchase Report</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form action="{{ route('pembelian.exportFilter') }}" method="GET">
                                    <div class="modal-body">
                                        <p>Pilih Tanggal Untuk Mencetak Laporan</p>
                                        <div class="form-group">
                                            <input type="text" placeholder="Pilih Tanggal" name="tanggal" id="tanggal"
                                                class="form-control tanggal" value="{{ old('tanggal') }}" />
                                        </div>
                                        <p>Pilih Supplier</p>
                                        <div class="form-group">
                                            <select required class="form-control select2" name="supplier_id"
                                                data-placeholder="Pilih Supplier" style="width: 100%;">
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">Export</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--End Modal Satu-->

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Nama Bahan Baku</td>
                                    <td>Jumlah</td>
                                    <td>Keterangan</td>
                                    <td>Tgl</td>
                                </tr>
                            </thead>
                            @foreach ($pembelians as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->bahanbaku->name }}</td>
                                    <td>{{ $value->jumlah }}</td>
                                    <td>{{ $value->keterangan }}</td>
                                    <td>{{ $value->tgl_dibuat }}</td>
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

            $('.tanggal').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'YYYY-MM-DD H:mm',
                startDate: startDate,
                endDate: endDate
            });
        });
    </script>
@endsection
