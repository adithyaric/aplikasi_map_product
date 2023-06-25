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
                <p>LMS</p>
                <!-- Status -->
                {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class=""><a href="/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-server"></i> <span>Master Data</span> <i
                        class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> Users</a></li></li>
                    <li><a href="{{ route('customer.index') }}"><i class="fa fa-users"></i> Kustomer</a></li></li>
                    <li><a href="{{ route('driver.index') }}"><i class="fa fa-users"></i> Drivers</a></li></li>
                    <li><a href="{{ route('satuan.index') }}"><i class="fa fa-circle"></i> Satuan</a></li></li>
                    <li><a href="{{ route('category.index') }}"><i class="fa fa-circle"></i> Kategori</a></li></li>
                    <li><a href="{{ route('bahanbaku.index') }}"><i class="fa fa-circle"></i> Bahan Baku</a></li></li>
                    <li><a href="{{ route('product.index') }}"><i class="fa fa-circle"></i> Product</a></li></li>
                    <li><a href="{{ route('project.index') }}"><i class="fa fa-circle"></i> Project</a></li></li>
                    <li><a href="{{ route('pembelian.index') }}"><i class="fa fa-circle"></i> Pembelian</a></li></li>
                    <li><a href="{{ route('penjualan.index') }}"><i class="fa fa-circle"></i> Penjualan</a></li></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
