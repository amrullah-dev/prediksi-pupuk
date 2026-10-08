@extends('layouts.app')

@section('title', 'Edit Jenis Pupuk')

@section('content')

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">

            Edit Jenis Pupuk

        </h1>

        <p class="page-subtitle">

            Perbarui data jenis pupuk.

        </p>

    </div>

</div>

<div class="card">

    <div class="card-body">

        <form action="{{ route('jenis-pupuk.update', $jenisPupuk->id_jenis) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">

                    ID Jenis

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $jenisPupuk->id_jenis }}"
                    readonly>

            </div>

            <div class="form-group mt-3">

                <label class="form-label">

                    Nama Jenis Pupuk

                </label>

                <input
                    type="text"
                    name="nama_pupuk"
                    class="form-control @error('nama_pupuk') is-invalid @enderror"
                    value="{{ old('nama_pupuk', $jenisPupuk->nama_pupuk) }}">

                @error('nama_pupuk')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>

            <div class="form-action mt-4">

                <a href="{{ route('jenis-pupuk.index') }}"
                    class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fa-solid fa-pen-to-square"></i>

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

@endsection