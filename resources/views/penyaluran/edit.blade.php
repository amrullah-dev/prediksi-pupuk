@extends('layouts.app')

@section('title', 'Edit Penyaluran')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Edit Penyaluran
        </h1>

        <p class="page-subtitle">
            Ubah jumlah penyaluran pupuk berdasarkan data yang telah dihitung.
        </p>

    </div>

</div>


<!-- ===========================================
                CARD EDIT
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Form Edit Penyaluran

            </div>

            <div class="card-subtitle">

                Silakan ubah jumlah penyaluran jika diperlukan.

            </div>

        </div>

    </div>

    <div class="card-body">

        {{-- Success --}}
        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        {{-- Error --}}
        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        {{-- Validation --}}
        @if($errors->any())

            <div class="alert alert-danger">

                <ul style="margin:0;padding-left:20px;">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('penyaluran.update',$penyaluran->id_penyaluran) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="form-group mb-3">

                <label class="form-label">

                    ID Penyaluran

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $penyaluran->id_penyaluran }}"
                    readonly>

            </div>

            <div class="form-group mb-3">

                <label class="form-label">

                    Periode

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ \Carbon\Carbon::parse($penyaluran->periode)->translatedFormat('F Y') }}"
                    readonly>

            </div>

            <div class="form-group mb-3">

                <label class="form-label">

                    Jenis Pupuk

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $penyaluran->jenisPupuk->nama_pupuk }}"
                    readonly>

            </div>

            <div class="form-group mb-3">

                <label class="form-label">

                    Nama Kios

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $penyaluran->kios->nama_kios }}"
                    readonly>

            </div>

            <div class="form-group mb-3">

                <label class="form-label">

                    Hasil Prediksi

                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ number_format($penyaluran->prediksi->hasil_prediksi,0,',','.') }} Kg"
                    readonly>

            </div>

            <div class="form-group mb-4">

                <label class="form-label">

                    Jumlah Penyaluran

                </label>

                <input
                    type="number"
                    name="jumlah_penyaluran"
                    class="form-control"
                    value="{{ old('jumlah_penyaluran', (int) $penyaluran->jumlah_penyaluran) }}"
                    required>

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('penyaluran.index') }}"
                    class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Update Penyaluran

                </button>

            </div>

        </form>

    </div>

</div>

@endsection