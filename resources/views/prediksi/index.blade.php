@extends('layouts.app')

@section('title', 'Prediksi ')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Prediksi Penyaluran Pupuk Cv. Mahatani Mandiri 
        </h1>

        <p class="page-subtitle">
            Lakukan proses prediksi kebutuhan pupuk.
        </p>

    </div>

</div>


<!-- ===========================================
            CARD PROSES PREDIKSI
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">
                Proses Prediksi
            </div>

            <div class="card-subtitle">
                Pilih periode yang akan diprediksi.
            </div>

        </div>

    </div>

    <div class="card-body">

        {{-- Success --}}
        @if(session('success'))

            <div class="alert alert-success">

                {!! session('success') !!}

            </div>

        @endif

        {{-- Error --}}
        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        {{-- Validation --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <ul style="margin:0;padding-left:20px;">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form action="{{ route('prediksi.proses') }}" method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">

                    Periode Prediksi

                </label>

                <input
                    type="month"
                    name="periode"
                    value="{{ old('periode') }}"
                    class="form-control"
                    required>

            </div>

            <div class="form-group">

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

                <i class="fa-solid fa-chart-line"></i>

                Proses Prediksi

            </button>

        </form>

    </div>

</div>


<div class="mt-3"></div>


<!-- ===========================================
                HASIL PREDIKSI
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Hasil Prediksi

            </div>

            <div class="card-subtitle">

                Daftar hasil prediksi.

            </div>

        </div>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari hasil prediksi...">

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table-modern" id="dataTable">

                <thead>

                    <tr>

                        <th width="15%">ID Prediksi</th>

                        <th>Nama Kios</th>

                        <th>Jenis Pupuk</th>

                        <th width="18%">Periode</th>

                        <th width="20%">Hasil Prediksi</th>

                        <th width="15%" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($prediksi as $item)

                    <tr>

                        <td>

                            <span class="table-id">

                                {{ $item->id_prediksi }}

                            </span>

                        </td>

                        <td>

                            {{ $item->kios->nama_kios }}

                        </td>

                        <td>

                            {{ $item->jenisPupuk->nama_pupuk }}

                        </td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}

                        </td>

                        <td>

                            <strong>

                                {{ number_format($item->hasil_prediksi,0,',','.') }}

                            </strong> Kg

                        </td>

                        <td>

                            <div class="action-group">

                                <form
                                    action="{{ route('prediksi.destroy',$item->id_prediksi) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data prediksi ini?')">

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

                        <td colspan="5">

                            <div class="empty-state">

                                <i class="fa-solid fa-chart-column"></i>

                                <h3>

                                    Belum Ada Data Prediksi

                                </h3>

                                <p>

                                    Silakan lakukan proses prediksi terlebih dahulu.

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