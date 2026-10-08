@extends('layouts.app')

@section('title', 'Edit Profile')

@section('styles')

<link rel="stylesheet"
      href="{{ asset('css/profile.css') }}">

@endsection

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">

            Edit Profile

        </h1>

        <p class="page-subtitle">

            Perbarui informasi akun Anda.

        </p>

    </div>

</div>


<!-- ===========================================
                PROFILE
=========================================== -->

<div class="profile-wrapper">

    <div class="profile-card">

        <!-- Avatar -->

        <div class="profile-header">

            <div class="profile-avatar">

                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}

            </div>

            <h2 class="profile-name">

                {{ auth()->user()->nama }}

            </h2>

        </div>


        <!-- FORM -->

        <form
            action="{{ route('profile.update') }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="profile-body">

                <!-- Nama -->

                <div class="form-group">

                    <label>

                        Nama

                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', auth()->user()->nama) }}"
                        placeholder="Masukkan nama lengkap"
                        class="@error('nama') is-invalid @enderror">

                    @error('nama')

                        <small class="error-text">

                            {{ $message }}

                        </small>

                    @enderror

                </div>


                <!-- Email -->

                <div class="form-group">

                    <label>

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        placeholder="Masukkan alamat email"
                        class="@error('email') is-invalid @enderror">

                    @error('email')

                        <small class="error-text">

                            {{ $message }}

                        </small>

                    @enderror

                </div>


                <!-- Password -->

                <div class="form-group">

                    <label>

                        Password Baru

                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Isi jika ingin mengganti password"
                            class="@error('password') is-invalid @enderror">

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                    @error('password')

                        <small class="error-text">

                            {{ $message }}

                        </small>

                    @enderror

                </div>


                <!-- Konfirmasi -->

                <div class="form-group">

                    <label>

                        Konfirmasi Password

                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Ulangi password baru">

                        <button
                            type="button"
                            class="toggle-password"
                            data-target="password_confirmation">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                </div>

            </div>


            <!-- Button -->

            <div class="profile-actions">

                <a href="{{ route('profile') }}"
                   class="btn-cancel">

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn-edit-profile">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/profile.js') }}"></script>

@endsection