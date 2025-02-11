<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>@yield('title')</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    {{-- <link rel="manifest" href="{{ asset('user/manifest.json') }}" /> --}}

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('img/x.png') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('img/x.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('img/x.png') }}" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="{{ asset('user/vendor/swiperjs-6.6.2/swiper-bundle.min.css') }}">

    <!-- style css for this template -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet" id="style">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Datetimepicker -->
    <link href="{{ asset('assets/adminlte/plugins/datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/adminlte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <!-- Daterangepicker -->
    <link href="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/select2/select2.min.css') }}">
</head>

<body class="body-scroll" data-page="index">
    {{-- @include('sweetalert::alert') --}}
    <!-- loader section -->
    {{-- <div class="container-fluid loader-wrap"> --}}
    {{-- <div class="row h-100"> --}}
    {{-- <div class="mx-auto text-center col-10 col-md-6 col-lg-5 col-xl-3 align-self-center"> --}}
    {{-- <div class="mx-auto loader-cube-wrap loader-cube-animate"> --}}
    {{-- <img src="{{ asset('user/img/x.png') }}" alt="Logo"> --}}
    {{-- </div> --}}
    {{-- <p class="mt-4">It's time for track budget<br><strong>Please wait...</strong></p> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    <!-- loader section ends -->
    {{-- @include('layouts.user.sidebar') --}}

    <!-- Begin page -->
    <main class="h-100">
        @auth
            <!-- Header -->
            <header class="header position-fixed">
                <div class="row">
                    <div class="col-auto">
                        <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                            <i class="bi bi-list"></i>
                        </a>
                    </div>
                    <div class="text-center col align-self-center">
                        <div class="logo-small">
                            <img src="{{ asset('img/x.png') }}" alt="">
                            <h5>DECAA.ID</h5>
                        </div>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-light btn-44">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            <!-- Header ends -->
        @endauth

        <!-- main page content -->
        <div class="container main-container">

            @yield('container')

        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

    @auth
        @include('layouts.user.footer')
    @endauth
    <!-- Required jquery and libraries -->
    <script src="{{ asset('user/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('user/js/popper.min.js') }}"></script>
    <script src="{{ asset('user/vendor/bootstrap-5/js/bootstrap.bundle.min.js') }}"></script>

    <!-- cookie js -->
    <script src="{{ asset('user/js/jquery.cookie.js') }}"></script>

    <!-- Customized jquery file  -->
    <script src="{{ asset('user/js/main.js') }}"></script>
    <script src="{{ asset('user/js/color-scheme.js') }}"></script>

    <!-- PWA app service registration and works -->
    {{-- <script src="{{ asset('user/js/pwa-services.js') }}"></script> --}}

    <!-- Chart js script -->
    <script src="{{ asset('user/vendor/chart-js-3.3.1/chart.min.js') }}"></script>

    <!-- Progress circle js script -->
    <script src="{{ asset('user/vendor/progressbar-js/progressbar.min.js') }}"></script>

    <!-- swiper js script -->
    <script src="{{ asset('user/vendor/swiperjs-6.6.2/swiper-bundle.min.js') }}"></script>

    <!-- page level custom script -->
    <script src="{{ asset('user/js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Datepicker -->
    <script src="{{ asset('assets/adminlte/plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/adminlte/plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- datetimerange -->
    <script src="{{ asset('assets/adminlte/plugins/daterangepicker/moment.js') }}"></script>
    <script src="{{ asset('assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        new DataTable('#example');
    </script>
    <!-- Select2 -->
    <script src="{{ asset('assets/adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $(".select2").select2();
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    @yield('page-script')
</body>

</html>
