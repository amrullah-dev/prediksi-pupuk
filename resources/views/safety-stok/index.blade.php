@extends('layouts.app')

@section('title', 'Safety Stok')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Safety Stok
        </h1>

        <p class="page-subtitle">
            Hitung safety stok dan jumlah pupuk siap salur berdasarkan hasil prediksi.
        </p>

    </div>

</div>

<!-- ===========================================
            CARD PROSES SAFETY STOK
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Perhitungan Safety Stok

            </div>

            <div class="card-subtitle">

                Pilih periode yang akan dihitung.

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

        <form action="{{ route('safety-stok.proses') }}" method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">

                    Periode

                </label>

                <input
                    type="month"
                    name="periode"
                    class="form-control"
                    required>

            </div>

            <div class="form-group mt-3">

                <label class="form-label">

                    Jenis Pupuk

                </label>

                <select
                    name="id_jenis"
                    class="form-control"
                    required>

                    <option value="">
                        -- Pilih Jenis Pupuk --
                    </option>

                    @foreach($jenisPupuk as $jenis)

                        <option
                            value="{{ $jenis->id_jenis }}"
                            {{ old('id_jenis') == $jenis->id_jenis ? 'selected' : '' }}>

                            {{ $jenis->nama_pupuk }}

                        </option>

                    @endforeach

                </select>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fa-solid fa-calculator"></i>

                Hitung Safety Stok

            </button>

        </form>

    </div>

</div>

<div class="mt-3"></div>

<!-- ===========================================
                HASIL SAFETY STOK
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Hasil Safety Stok

            </div>

            <div class="card-subtitle">

                Daftar hasil perhitungan safety stok dan siap salur.

            </div>

        </div>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari data safety stok...">

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table-modern" id="dataTable">

                <thead>

                    <tr>

                        <th width="15%">ID Safety</th>
                        <th>Jenis Pupuk</th>
                        <th width="18%">Periode</th>
                        <th>Safety Stok</th>
                        <th>Siap Salur</th>
                        <th width="15%" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $item)

                        <tr>

                            <td>

                                <span class="table-id">

                                    {{ $item->id_safety }}

                                </span>

                            </td>

                            <td>

                                {{ $item->jenisPupuk->nama_pupuk }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($item->safety_stok,2,',','.') }}

                                </strong> Kg

                            </td>

                            <td>

                                <strong>

                                    {{ number_format($item->siap_salur,2,',','.') }}

                                </strong> Kg

                            </td>

                            <td>

                                <div class="action-group">

                                    <form
                                        action="{{ route('safety-stok.destroy',$item->id_safety) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger">

                                            <i class="fa-solid fa-trash"></i>

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="empty-state">

                                    <i class="fa-solid fa-shield-halved"></i>

                                    <h3>

                                        Belum Ada Data Safety Stok

                                    </h3>

                                    <p>

                                        Silakan lakukan perhitungan safety stok terlebih dahulu.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection