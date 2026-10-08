@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Laporan
        </h1>

        <p class="page-subtitle">
            Tampilkan laporan berdasarkan jenis laporan dan periode tertentu.
        </p>

    </div>

</div>

<!-- ===========================================
                FILTER LAPORAN
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Filter Laporan

            </div>

            <div class="card-subtitle">

                Pilih jenis laporan dan periode.

            </div>

        </div>

    </div>

    <div class="card-body">

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

        <form action="{{ route('laporan.tampilkan') }}" method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">

                    Jenis Laporan

                </label>

                <select
                    name="jenis"
                    class="form-select"
                    required>

                    <option value="">
                        -- Pilih Jenis Laporan --
                    </option>

                    <option value="historis"
                        {{ $jenis=='historis' ? 'selected' : '' }}>

                        Historis Penyaluran

                    </option>

                    <option value="prediksi"
                        {{ $jenis=='prediksi' ? 'selected' : '' }}>

                        Prediksi

                    </option>
                    
                    <option value="safety"
                        {{ $jenis=='safety' ? 'selected' : '' }}>

                        Safety Stok

                    </option>

                    <option value="penyaluran"
                        {{ $jenis=='penyaluran' ? 'selected' : '' }}>

                        Penyaluran

                    </option>

                </select>

            </div>

            <div class="form-group mt-3">

                <label class="form-label">

                    Jenis Pupuk

                </label>

                <select
                    name="id_jenis"
                    class="form-select">

                    <option value="">

                        Semua Jenis

                    </option>

                    @foreach($daftarJenis as $item)

                        <option
                            value="{{ $item->id_jenis }}"
                            {{ $idJenis == $item->id_jenis ? 'selected' : '' }}>

                            {{ $item->nama_pupuk }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label class="form-label">

                    Periode

                </label>

                <input
                    type="month"
                    name="periode"
                    class="form-control"
                    value="{{ old('periode', $periode ? \Carbon\Carbon::parse($periode)->format('Y-m') : '') }}">
                
                <small class="text-muted">
                    Kosongkan periode untuk menampilkan semua data.
                </small>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fa-solid fa-file-lines"></i>

                Tampilkan Laporan

            </button>

        </form>

    </div>

</div>



@if($jenis)

<div class="card mt-3">

    <div class="card-header">

        <div>

            <div class="card-title">

                @switch($jenis)

                    @case('historis')

                        Laporan Historis Penyaluran

                    @break

                    @case('prediksi')

                        Laporan Prediksi

                    @break

                    @case('safety')

                        Laporan Safety Stok

                    @break

                    @case('penyaluran')

                        Laporan Penyaluran

                    @break

                @endswitch

            </div>

            <div class="card-subtitle">

                Periode

                {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}

            </div>

        </div>

        <span class="badge badge-primary">

            <i class="fa-solid fa-calendar"></i>

            {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}

        </span>

    </div>

    <div class="card-body">

        @if($jenis == 'penyaluran')

            @if($data->isEmpty())

                <div class="empty-state">

                    <i class="fa-solid fa-box-open"></i>

                    <h3>
                        Data Tidak Ditemukan
                    </h3>

                    <p>
                        Tidak ada data penyaluran pada periode yang dipilih.
                    </p>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table-modern" id="dataTable">

                        <thead>

                            <tr>

                                <th>ID Penyaluran</th>
                                <th>Periode</th>
                                <th>Jenis Pupuk</th>
                                <th>Nama Kios</th>
                                <th>Hasil Prediksi</th>
                                <th>Proporsi (%)</th>
                                <th>Jumlah Penyaluran</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $item)

                                <tr>

                                    <td>{{ $item->id_penyaluran }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
                                    </td>

                                    <td>
                                        {{ $item->jenisPupuk->nama_pupuk }}
                                    </td>

                                    <td>
                                        {{ $item->kios->nama_kios }}
                                    </td>

                                    <td>
                                        {{ number_format($item->prediksi->hasil_prediksi,0,',','.') }} Kg
                                    </td>

                                    <td>
                                        {{ number_format($item->proporsi * 100, 2, ',', '.') }} %
                                    </td>

                                    <td>
                                        {{ number_format($item->jumlah_penyaluran,0,',','.') }} Kg
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                

            @endif

            @elseif($jenis == 'prediksi')

            @if($data->isEmpty())

                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>Data Tidak Ditemukan</h3>
                    <p>Tidak ada data prediksi pada periode yang dipilih.</p>
                </div>

            @else

                <div class="table-responsive">

                    <table class="table-modern">

                        <thead>

                            <tr>
                                <th>ID Prediksi</th>
                                <th>Nama Kios</th>
                                <th>Jenis Pupuk</th>
                                <th>Hasil Prediksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $item)

                                <tr>

                                    <td>{{ $item->id_prediksi }}</td>

                                    <td>{{ $item->kios->nama_kios }}</td>

                                    <td>{{ $item->jenisPupuk->nama_pupuk }}</td>

                                    <td>{{ number_format($item->hasil_prediksi,0,',','.') }} Kg</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

            @elseif($jenis == 'safety')

            @if($data->isEmpty())

                <div class="empty-state">

                    <i class="fa-solid fa-box-open"></i>

                    <h3>Data Tidak Ditemukan</h3>

                    <p>Tidak ada data safety stok pada periode yang dipilih.</p>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table-modern">

                        <thead>

                            <tr>

                                <th>ID Safety</th>

                                <th>Periode</th>

                                <th>Jumlah Stok</th>

                                <th>Safety Stok</th>

                                <th>Siap Salur</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $item)

                                <tr>

                                    <td>{{ $item->id_safety }}</td>

                                    <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td>

                                    <td>{{ number_format($item->stokpupuk->jumlah_stok,0,',','.') }} Kg</td>

                                    <td>{{ number_format($item->safety_stok,0,',','.') }} Kg</td>

                                    <td>{{ number_format($item->siap_salur,0,',','.') }} Kg</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

            @elseif($jenis == 'historis')

            @if($data->isEmpty())

                <div class="empty-state">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>Data Tidak Ditemukan</h3>
                    <p>Tidak ada data historis pada periode yang dipilih.</p>
                </div>

            @else

                <div class="table-responsive">

                    <table class="table-modern">

                        <thead>

                            <tr>
                                <th>ID Historis</th>
                                <th>Nama Kios</th>
                                <th>Jenis Pupuk</th>
                                <th>Jumlah Penyaluran</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $item)

                                <tr>

                                    <td>{{ $item->id_historis }}</td>

                                    <td>{{ $item->kios->nama_kios }}</td>

                                    <td>{{ $item->jenisPupuk->nama_pupuk }}</td>

                                    <td>{{ number_format($item->jumlah_penyaluran,0,',','.') }} Kg</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        @endif

        @if($jenis && $data->isNotEmpty())

        <div class="d-flex justify-content-end gap-2 mt-3">

            <a href="{{ route('laporan.print',[
                'jenis'=>$jenis,
                'id_jenis'=>$idJenis,
                'periode'=>$periode ? \Carbon\Carbon::parse($periode)->format('Y-m') : null
            ]) }}"
            target="_blank"
            class="btn btn-success">

                <i class="fa-solid fa-print"></i>

                Print

            </a>

            <a href="{{ route('laporan.pdf',[
                'jenis'=>$jenis,
                'id_jenis'=>$idJenis,
                'periode'=>$periode ? \Carbon\Carbon::parse($periode)->format('Y-m') : null
            ]) }}"
            class="btn btn-danger">

                <i class="fa-solid fa-file-pdf"></i>

                PDF

            </a>

            <a href="{{ route('laporan.excel',[
                'jenis'=>$jenis,
                'id_jenis'=>$idJenis,
                'periode'=>$periode ? \Carbon\Carbon::parse($periode)->format('Y-m') : null
            ]) }}"
            class="btn btn-success">

                <i class="fa-solid fa-file-excel"></i>

                Excel

            </a>

        </div>

        @endif

    </div>

</div>

@endif

@endsection