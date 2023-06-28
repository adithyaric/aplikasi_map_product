@extends('layouts.master')
@section('container')
    <div class="content">
        <div class="box">
            <div class="box-body">
                <input type="text" class="datepicker">
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript">
        $('.datepicker').datepicker({
            daysOfWeekDisabled: [0],
            multidate: true,
            clearBtn: true
        });
    </script>
@endsection
