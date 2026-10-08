<!-- =========================
            SIDEBAR PEMILIK
========================= -->

<div class="sidebar">

    <!-- Logo -->
    <div class="sidebar-header">

        <div class="logo-wrap">

            <div class="logo-circle">
                <img
                    src="{{ asset('images/logo_mahatani.png') }}"
                    alt="Logo CV. Mahatani Mandiri">
            </div>

            <div class="logo-text">

                <h2>CV. Mahatani Mandiri</h2>

                <p>Sistem Prediksi Pupuk</p>

            </div>

        </div>

    </div>

    <!-- Menu -->
    <div class="nav-section">

        <!-- =========================
                UTAMA
        ========================== -->

        <div class="nav-label">
            Utama
        </div>

        <a href="{{ url('/') }}"
           class="{{ request()->is('/') ? 'active' : '' }}">

            <i class="fa-solid fa-house"></i>

            <span>Dashboard</span>

        </a>

        <!-- =========================
                LAPORAN
        ========================== -->

        <div class="nav-label">
            Laporan
        </div>

        <a href="{{ route('laporan.index') }}"
           class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">

            <i class="fa-solid fa-file-lines"></i>

            <span>Laporan</span>

        </a>

    </div>

    <!-- Footer -->
    <div class="sidebar-footer">

        <a href="{{ route('profile') }}" class="user-card">

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->nama ?? 'P', 0, 1)) }}
            </div>

            <div class="user-info">

                <p>{{ auth()->user()->nama ?? 'Pemilik' }}</p>

                <span>{{ ucfirst(auth()->user()->role ?? 'Owner') }}</span>

            </div>

            <i class="fa-solid fa-chevron-right"></i>

        </a>

        @if(Route::has('logout'))

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit" class="logout-btn">

                    <i class="fa-solid fa-arrow-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        @else

            <button class="logout-btn">

                <i class="fa-solid fa-arrow-right-from-bracket"></i>

                Logout

            </button>

        @endif

    </div>

</div>