@extends('layouts.auth')

@section('title', 'Reset Password')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/reset-password.css') }}">

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

    <div class="login-right">

        <div class="login-box">

            <h2>

                Reset Password

            </h2>

            <p>

                Silakan buat password baru untuk akun Anda.

            </p>

            <form method="POST"
                  action="{{ route('reset-password.update') }}">

                @csrf

                <div class="input-group">

                    <label>

                        Password Baru

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan password baru">

                    </div>

                </div>

                <div class="input-group">

                    <label>

                        Konfirmasi Password

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password baru">

                    </div>

                </div>

                <button
                    class="login-btn"
                    type="submit">

                    Simpan Password

                </button>

                <div class="forgot-password">

                    <a href="{{ route('login') }}">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali ke Login

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/reset-password.js') }}"></script>

@endsection