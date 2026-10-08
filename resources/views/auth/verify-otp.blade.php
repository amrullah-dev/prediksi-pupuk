@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/verify-otp.css') }}">

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

    <!-- ==========================================
                    PANEL KANAN
    =========================================== -->

    <div class="login-right">

        <div class="login-box">

            <h2>

                Verifikasi OTP

            </h2>

            <p>

                Masukkan kode OTP yang telah dikirim ke email Anda.

            </p>

            {{-- Flash Message --}}
            @if(session('success'))

                <div class="alert-success">

                    {{ session('success') }}

                </div>

            @endif

            @if(session('error'))

                <div class="alert-error">

                    {{ session('error') }}

                </div>

            @endif

            <form method="POST"
                  action="{{ route('verify-otp.verify') }}">

                @csrf

                <div class="input-group">

                    <label>

                        Kode OTP

                    </label>

                    <div class="input-box">

                        <i class="fa-solid fa-key"></i>

                        <input
                            type="text"
                            name="otp"
                            placeholder="Masukkan kode OTP"
                            maxlength="6"
                            required>

                    </div>

                </div>

                <button
                    type="submit"
                    class="login-btn">

                    Verifikasi OTP

                </button>

                <div class="forgot-password">

                    <a href="{{ route('forgot-password') }}">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kirim Ulang OTP

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/verify-otp.js') }}"></script>

@endsection