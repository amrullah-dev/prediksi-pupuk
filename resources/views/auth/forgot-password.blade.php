@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/forgot-password.css') }}">

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
                penyaluran pupuk secara lebih akurat
                menggunakan metode Theta.

            </p>

        </div>

    </div>

    <!-- ==========================
            RIGHT PANEL
    =========================== -->

    <div class="login-right">

        <div class="login-box">

            <h2>

                Lupa Password

            </h2>

            <p>

                Masukkan alamat email yang terdaftar pada sistem.
                Kami akan mengirimkan kode OTP untuk
                mengatur ulang password Anda.

            </p>

            <form method="POST"
                  action="{{ route('forgot-password.send') }}">

                @csrf

                {{-- Pesan Berhasil --}}
                @if(session('success'))

                    <div class="alert-success">

                        <i class="fa-solid fa-circle-check"></i>

                        <span>

                            {{ session('success') }}

                        </span>

                    </div>

                @endif

                {{-- Pesan Error --}}
                @if(session('error'))

                    <div class="alert-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>

                            {{ session('error') }}

                        </span>

                    </div>

                @endif

                <!-- ==========================
                        EMAIL
                =========================== -->

                <div class="input-group @error('email') has-error @enderror">

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
                        BUTTON
                =========================== -->

                <button
                    type="submit"
                    class="login-btn">

                    <i class="fa-solid fa-paper-plane"></i>

                    Kirim Kode OTP

                </button>

                <!-- ==========================
                        BACK TO LOGIN
                =========================== -->

                <div class="forgot-password">

                    <a href="{{ route('login') }}">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali ke Login

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

<script src="{{ asset('js/forgot-password.js') }}"></script>

@endsection