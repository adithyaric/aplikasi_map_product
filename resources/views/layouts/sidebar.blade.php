<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/logo.png') }}" class="img-circle" alt="User Image"><br>
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <p>MAPPING PRODUCT</p>
                <!-- Status -->
                {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ route('locations', ['type' => 'provinsi']) }}"><i class="fa fa-map"></i> <span>Peta</span></a></li>
            <li><a href="{{ route('locations.index') }}"><i class="fa fa-map-marker"></i> <span>Area</span></a></li>
            <li><a href="#"><i class="fa fa-bar-chart"></i> Statitstik</a></li>
            <li><a href="{{ route('product.index') }}"><i class="fa fa-cube"></i> Product</a></li>
            <li><a href="{{ route('product.input.form') }}"><i class="fa fa-cubes"></i> Penyebaran Product</a></li>
            <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> Users</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
            {{-- @if (auth()->user()->role == 'Administrasi') --}}
                {{-- <li class="treeview"> --}}
                    {{-- <a href="#"> --}}
                        {{-- <i class="fa fa-server"></i> <span>Master Data</span> <i --}}
                            {{-- class="fa fa-angle-left pull-right"></i> --}}
                    {{-- </a> --}}
                    {{-- <ul class="treeview-menu"> --}}
                        {{-- <li><a href="{{ route('satuan.index') }}"><i class="fa fa-suitcase"></i> Units</a></li> --}}
                        {{-- <li><a href="{{ route('category.index') }}"><i class="fa fa-reorder"></i> Categories</a></li> --}}
                        {{-- <li><a href="{{ route('supplier.index') }}"><i class="fa fa-user"></i> Supplier</a></li> --}}
                        {{-- <li><a href="{{ route('customer.index') }}"><i class="fa fa-users"></i> Customers</a></li> --}}
                        {{-- <li><a href="{{ route('truck.index') }}"><i class="fa fa-car"></i> No Kendaraan</a></li> --}}
                        {{-- <li><a href="{{ route('driver.index') }}"><i class="fa fa-users"></i> Drivers</a></li> --}}
                        {{-- <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> Users</a></li> --}}
                    {{-- </ul> --}}
                {{-- </li> --}}
{{--  --}}
                {{-- <li class="treeview"> --}}
                    {{-- <a href="#"> --}}
                        {{-- <i class="fa fa-server"></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i> --}}
                    {{-- </a> --}}
                    {{-- <ul class="treeview-menu"> --}}
                        {{-- <li><a href="{{ route('bahanbaku.index') }}"><i class="fa fa-legal"></i> Materials</a></li> --}}
                        {{-- <li><a href="{{ route('stock.index') }}"><i class="fa fa-filter"></i> Stock</a></li> --}}
                        {{-- <li><a href="{{ route('product.index') }}"><i class="fa fa-cube"></i> Product</a></li> --}}
                    {{-- </ul> --}}
                {{-- </li> --}}
{{--  --}}
                {{-- <li><a href="{{ route('pembelian.index') }}"><i class="fa fa-exchange"></i> <span>Purchase</span></a> --}}
                {{-- </li> --}}
{{--  --}}
                {{-- <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> --}}
                        {{-- <span>Orders</span></a></li> --}}
{{--  --}}
                {{-- <li><a href="{{ route('pengiriman.index') }}"><i class="fa fa-send"></i> <span>Delivery</span></a></li> --}}
            {{-- @endif --}}
            {{-- @if (auth()->user()->role == 'Administrasi' || auth()->user()->role == 'Owner') --}}
                {{-- <li><a href="{{ route('project.index') }}"><i class="fa fa-bookmark"></i> <span>Projects</span></a> --}}
                {{-- </li> --}}
                {{-- <li><a href="{{ route('entry.index') }}"><i class="fa fa-bar-chart"></i> <span>Daily Targets</span></a> --}}
                {{-- </li> --}}
            {{-- @endif --}}
            {{-- @if (auth()->user()->role == 'Administrasi' || auth()->user()->role == 'Finance') --}}
                {{-- <li class="treeview"> --}}
                    {{-- <a href="#"> --}}
                        {{-- <i class="fa fa-print"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i> --}}
                    {{-- </a> --}}
                    {{-- <ul class="treeview-menu"> --}}
                        {{-- <li><a href="{{ route('pembelian.exp') }}"><i class="fa fa-print"></i> Export Purchase</a></li> --}}
                        {{-- <li><a href="{{ route('project.exp') }}"><i class="fa fa-print"></i> Export Projects</a></li> --}}
                        {{-- <li><a href="{{ route('pengiriman.exp') }}"><i class="fa fa-print"></i> Export Delivery</a> --}}
                        {{-- </li> --}}
                        {{-- <li><a href="{{ route('pengiriman.inout') }}"><i class="fa fa-print"></i> Export Delivery In --}}
                                {{-- Out</a></li> --}}
                    {{-- </ul> --}}
                {{-- </li> --}}
            {{-- @endif --}}
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
