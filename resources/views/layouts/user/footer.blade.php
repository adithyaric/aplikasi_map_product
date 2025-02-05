<!-- Footer -->
<footer class="footer">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            {{-- <li class="nav-item"> --}}
                {{-- <a class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}" href="{{ route('dashboard') }}"> --}}
                    {{-- <span> --}}
                        {{-- <i class="nav-icon bi bi-house"></i> --}}
                        {{-- <span class="nav-text">dashboard</span> --}}
                    {{-- </span> --}}
                {{-- </a> --}}
            {{-- </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('product.input.form*')) ? 'active' : '' }}" href="{{ route('product.input.form') }}">
                    <span>
                        <i class="nav-icon bi bi-house"></i>
                        <span class="nav-text">Input Penyebaran</span>
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('product.input.history')) ? 'active' : '' }}" href="{{ route('product.input.history') }}">
                    <span>
                        <i class="nav-icon bi bi-box size-32"></i>
                        <span class="nav-text">Penyebaran History</span>
                    </span>
                </a>
            </li>
         </ul>
    </div>
</footer>
<!-- Footer ends-->
