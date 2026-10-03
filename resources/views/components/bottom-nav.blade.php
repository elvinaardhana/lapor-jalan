<div class="bottom-nav">

    <a href="{{ route('home') }}"
       class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">

        <div class="nav-icon">
            <i class="bi bi-house-fill"></i>
        </div>

        <span>Beranda</span>

    </a>
 <a href="{{ route('laporan.publik') }}"
       class="nav-item {{ request()->routeIs('laporan.publik') ? 'active' : '' }}">

        <div class="nav-icon">
            <i class="bi bi-card-list"></i>
        </div>

        <span>Laporan</span>

    </a>


    @auth

<a href="{{ route('laporan.create') }}"
   class="nav-item {{ request()->routeIs('laporan.create') ? 'active' : '' }}">

    <div class="nav-icon">
    <i class="bi bi-plus-circle-fill"></i>
    </div>

    <span>Lapor</span>

</a>

@else

<a href="{{ route('login') }}"
   class="nav-item">

    <div class="nav-icon">
    <i class="bi bi-plus-circle-fill"></i>
    </div>

    <span>Lapor</span>

</a>

@endauth

   

    <a href="{{ route('peta') }}"
       class="nav-item {{ request()->routeIs('peta') ? 'active' : '' }}">

        <div class="nav-icon">
            <i class="bi bi-map-fill"></i>
        </div>

        <span>Peta</span>

    </a>

    @auth

    <a href="{{ route('akun') }}"
       class="nav-item {{ request()->routeIs('akun') ? 'active' : '' }}">

        <div class="nav-icon">
            <i class="bi bi-person-fill"></i>
        </div>

        <span>Profil</span>

    </a>

    @else

    <a href="{{ route('akun') }}"
       class="nav-item">

        <div class="nav-icon">
            <i class="bi bi-person-fill"></i>
        </div>

        <span>Akun</span>

    </a>

    @endauth

</div>