<!-- Footer -->
<footer class="footer">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span>
                        <i class="nav-icon bi bi-house"></i>
                        <span class="nav-text">dashboard</span>
                    </span>
                </a>
            </li>
         </ul>
    </div>
</footer>
<!-- Footer ends-->
