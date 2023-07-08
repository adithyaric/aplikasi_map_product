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
                <p>PT. TUBAN PRIMA ENERGI</p>
                <!-- Status -->
                {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class=""><a href="/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-server"></i> <span>Master Data</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('satuan.index') }}"><i class="fa fa-suitcase"></i> Units</a></li>
                    <li><a href="{{ route('category.index') }}"><i class="fa fa-reorder"></i> Categories</a></li>
                    <li><a href="{{ route('customer.index') }}"><i class="fa fa-users"></i> Customers</a></li>
                    <li><a href="{{ route('driver.index') }}"><i class="fa fa-users"></i> Drivers</a></li>
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> Users</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-server"></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('bahanbaku.index') }}"><i class="fa fa-legal"></i> Materials</a></li>
                    <li><a href="{{ route('stock.index') }}"><i class="fa fa-filter"></i> Stock</a></li>
                    <li><a href="{{ route('product.index') }}"><i class="fa fa-cube"></i> Product</a></li>
                </ul>
            </li>

            <li><a href="{{ route('pembelian.index') }}"><i class="fa fa-exchange"></i> Purchase</a></li>

            <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-shopping-cart"></i> Orders</a></li>

            <li><a href="{{ route('pengiriman.index') }}"><i class="fa fa-send"></i> Delivery</a></li>

            <li><a href="{{ route('project.index') }}"><i class="fa fa-bookmark"></i> Projects</a></li>

            <li><a href="{{ route('entry.index') }}"><i class="fa fa-bar-chart"></i> Daily Targets</a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-print"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('pembelian.exp') }}"><i class="fa fa-print"></i> Export Purchase</a></li>
                    <li><a href="{{ route('pengiriman.exp') }}"><i class="fa fa-print"></i> Export Delivery</a></li>
                    <li><a href="{{ route('project.exp') }}"><i class="fa fa-print"></i> Export Projects</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
