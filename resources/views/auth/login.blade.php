@extends('layouts.auth')

@section('title', 'Login')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/login.css') }}">

@endsection

@section('content')



<div class="login-container">

    <!-- ==========================
            LEFT PANEL
    =========================== -->

    <div class="login-left">

        <div class="brand">

            <div class="logo-circle">

                <img
                        src="{{ asset('images/logo_mahatani.png') }}"
                        alt="Logo CV. Mahatani Mandiri">

            </div>

            <h1>

                CV. MAHATANI MANDIRI

            </h1>

            <div class="line"></div>

            <h2>

                Sistem Prediksi Dalam Penentuan
                Jumlah Penyaluran Pupuk

            </h2>

            <div class="brand-icon">

                <i class="fa-solid fa-seedling"></i>

            </div>

            <p>

                Membantu proses penentuan jumlah
                penyaluran pupuk.

            </p>

        </div>

    </div>

    <!-- ==========================
            RIGHT PANEL
    =========================== -->

    <div class="login-right">

        <div class="login-box">

            <h2>

                Selamat Datang

            </h2>

            <p>

                Silakan masuk menggunakan akun Anda

            </p>

            <form method="POST"
                action="{{ route('login.authenticate') }}">

                @csrf

                {{-- ==========================
                        PESAN ERROR LOGIN
                =========================== --}}
                @if(session('error'))

                    <div class="alert-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>{{ session('error') }}</span>

                    </div>

                @endif

                <!-- ==========================
                        EMAIL
                =========================== -->

                <div class="input-group">

                    <label for="email">

                        Email

                    </label>

                    <div class="input-box">

                        <i class="fa-regular fa-envelope"></i>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            required
                            autocomplete="email">

                    </div>

                    @error('email')

                        <small class="input-error">

                            {{ $message }}

                        </small>

                    @enderror

                </div>

                <!-- ==========================
                        PASSWORD
                =========================== -->

                <div class="input-group">

                    <label for="password">

                        Password

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password">

                        <button
                            type="button"
                            class="toggle-password">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                    @error('password')

                        <small class="input-error">

                            {{ $message }}

                        </small>

                    @enderror

                </div>

                <!-- ==========================
                        REMEMBER ME
                =========================== -->

                <!-- <div class="remember">

                    <label>

                        <input
                            type="checkbox"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        Ingat Saya

                    </label>

                </div> -->

                <!-- ==========================
                        LOGIN BUTTON
                =========================== -->

                <button
                    type="submit"
                    class="login-btn">

                    Login

                </button>

                <!-- ==========================
                        FORGOT PASSWORD
                =========================== -->

                <div class="forgot-password">

                    <a href="{{ route('forgot-password') }}">

                        Lupa Password?

                    </a>

                </div>

            </form>

            <div class="copyright">

                © {{ date('Y') }}
                CV. Mahatani Mandiri.
                All Rights Reserved.

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/login.js') }}"></script>

@endsection