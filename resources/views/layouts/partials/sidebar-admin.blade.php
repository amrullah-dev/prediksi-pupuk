<!-- =========================
            SIDEBAR
    ========================== -->

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

            <div class="nav-label">
                Utama
            </div>

            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'active' : '' }}">

                <i class="fa-solid fa-house"></i>

                <span>Dashboard</span>

            </a>

            <a href="{{ route('kios.index') }}"
               class="{{ request()->routeIs('kios.*') ? 'active' : '' }}">

                <i class="fa-solid fa-store"></i>

                <span>Data Kios</span>

            </a>

            <a href="{{ route('jenis-pupuk.index') }}"
               class="{{ request()->routeIs('jenis-pupuk.*') ? 'active' : '' }}">

                <i class="fa-solid fa-sack-xmark"></i>

                <span>Jenis Pupuk</span>

            </a>


            <div class="nav-label">
                Manajemen Data
            </div>

            <a href="{{ route('historis-penyaluran.index') }}"
               class="{{ request()->routeIs('historis-penyaluran.*') ? 'active' : '' }}">

                <i class="fa-solid fa-clock-rotate-left"></i>

                <span>Historis Penyaluran</span>

            </a>

            <a href="{{ route('stok-pupuk.index') }}"
               class="{{ request()->routeIs('stok-pupuk.*') ? 'active' : '' }}">

                <i class="fa-solid fa-boxes-stacked"></i>

                <span>Stok Pupuk</span>

            </a>


            <div class="nav-label">
                Analitik
            </div>

            <a href="{{ route('prediksi.index') }}"
               class="{{ request()->routeIs('prediksi.*') ? 'active' : '' }}">

                <i class="fa-solid fa-chart-line"></i>

                <span>Prediksi</span>

            </a>

            <a href="{{ route('safety-stok.index') }}"
               class="{{ request()->routeIs('safety-stok.*') ? 'active' : '' }}">

                <i class="fa-solid fa-shield-halved"></i>

                <span>Safety Stok</span>

            </a>


            <div class="nav-label">
                Operasional
            </div>

            <a href="{{ route('penyaluran.index') }}"
               class="{{ request()->routeIs('penyaluran.*') ? 'active' : '' }}">

                <i class="fa-solid fa-truck-fast"></i>

                <span>Penyaluran</span>

            </a>

            {{--<a href="{{ route('laporan.index') }}"
               class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">

                <i class="fa-solid fa-file-lines"></i>

                <span>Laporan</span>

            </a>--}}

        </div>

        <!-- Footer -->
        <div class="sidebar-footer">

            <a href="{{ route('profile') }}" class="user-card">

                <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
            </div>

            <div class="user-info">

                <p>{{ auth()->user()->nama ?? 'Admin' }}</p>

                <span>{{ ucfirst(auth()->user()->role ?? 'Administator') }}</span>

            </div>

                <i class="fa-solid fa-chevron-right"></i>

            </a>

            {{-- Jika route logout sudah dibuat --}}
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