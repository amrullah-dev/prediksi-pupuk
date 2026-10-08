@extends('layouts.app')

@section('title', 'Tambah Jenis Pupuk')

@section('content')

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">

            Tambah Jenis Pupuk

        </h1>

        <p class="page-subtitle">

            Tambahkan data jenis pupuk baru.

        </p>

    </div>

</div>

<div class="card">

    <div class="card-body">

        <form action="{{ route('jenis-pupuk.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">

                    Nama Jenis Pupuk

                </label>

                <input
                    type="text"
                    name="nama_pupuk"
                    class="form-control @error('nama_pupuk') is-invalid @enderror"
                    placeholder="Masukkan nama jenis pupuk"
                    value="{{ old('nama_pupuk') }}">

                @error('nama_pupuk')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="form-action">

                <a href="{{ route('jenis-pupuk.index') }}"
                    class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection