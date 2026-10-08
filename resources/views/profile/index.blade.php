@extends('layouts.app')

@section('title', 'Profile Saya')

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

            Profile Saya

        </h1>

        <p class="page-subtitle">

            Informasi akun pengguna.

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


        <!-- Body -->

        <div class="profile-body">

            <div class="profile-item">

                <span class="profile-label">

                    Nama

                </span>

                <span class="profile-value">

                    {{ auth()->user()->nama }}

                </span>

            </div>


            <div class="profile-item">

                <span class="profile-label">

                    Email

                </span>

                <span class="profile-value">

                    {{ auth()->user()->email }}

                </span>

            </div>


            <div class="profile-item">

                <span class="profile-label">

                    Password

                </span>

                <span class="profile-value">

                    ••••••••••••

                </span>

            </div>

        </div>


        <!-- Button -->

        <div class="profile-actions">

            <a href="{{ route('profile.edit') }}"
               class="btn-edit-profile">

                <i class="fa-solid fa-user-pen"></i>

                Edit Profile

            </a>

        </div>

    </div>

</div>

@if(session('success'))

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const Toast = Swal.mixin({

    toast: true,

    position: 'top-end',

    showConfirmButton: false,

    timer: 2500,

    timerProgressBar: true,

    showClass: {

        popup: 'animate__animated animate__fadeInDown'

    },

    hideClass: {

        popup: 'animate__animated animate__fadeOutUp'

    },

    didOpen: (toast) => {

        toast.addEventListener('mouseenter', Swal.stopTimer)

        toast.addEventListener('mouseleave', Swal.resumeTimer)

    }

});

Toast.fire({

    icon: 'success',

    title: 'Profile berhasil diperbarui.'

});

</script>

@endif

@endsection