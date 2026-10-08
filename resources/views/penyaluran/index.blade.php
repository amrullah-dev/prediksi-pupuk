@extends('layouts.app')

@section('title', 'Penyaluran')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Penentuan Jumlah Penyaluran
        </h1>

        <p class="page-subtitle">
            Hitung jumlah penyaluran pupuk berdasarkan hasil prediksi dan safety stok.
        </p>

    </div>

</div>

<!-- ===========================================
            CARD PROSES PENYALURAN
=========================================== -->

<div class="card">

    <div class="card-header">

        <div>

            <div class="card-title">

                Proses Penyaluran

            </div>

            <div class="card-subtitle">

                Pilih periode untuk menghitung penyaluran.

            </div>

        </div>

    </div>

    <div class="card-body">

        {{-- Success --}}
        @if(session('success'))

            <div class="alert alert-success">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif

        {{-- Error --}}
        @if(session('error'))

            <div class="alert alert-danger">

                <i class="fa-solid fa-circle-xmark"></i>

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
            action="{{ route('penyaluran.hitung') }}"
            method="POST">

            @csrf

            <div class="form-group">

                <label class="form-label">

                    Periode

                </label>

                <input
                    type="month"
                    name="periode"
                    class="form-control"
                    value="{{ old('periode') }}"
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

                Hitung Penyaluran

            </button>

        </form>

    </div>

</div>

<!-- ===========================================
                DATA PENYALURAN
=========================================== -->

<div class="card mt-3">

    <div class="card-header">

        <div>

            <div class="card-title">

                Data Penyaluran

            </div>

            <div class="card-subtitle">

                Data hasil penyaluran pupuk yang telah dihitung dan disimpan.

            </div>

        </div>

        <div style="display:flex; align-items:center; gap:12px;">

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari data penyaluran...">

            </div>

            @if($penyaluran->isNotEmpty())

                <form
                    action="{{ route('penyaluran.destroyAll') }}"
                    method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh data penyaluran? Data yang telah dihapus tidak dapat dikembalikan.')">

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="fa-solid fa-trash"></i>

                        Hapus Semua Data

                    </button>

                </form>

            @endif

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table-modern" id="dataTable">

                <thead>

                    <tr>
                    <th width="10%">ID Penyaluran</th>
                    <th width="11%">Periode</th>
                    <th width="13%">Jenis Pupuk</th>
                    <th width="13%">Nama Kios</th>
                    <th width="13%" class="text-end">Prediksi</th>
                    <th width="12%" class="text-end">Aktual</th>
                    <th width="10%" class="text-center">Error</th>
                    <th width="9%" class="text-center">Proporsi</th>
                    <th width="15%" class="text-end">Penyaluran</th>
                </tr>

                </thead>

                <tbody>

                    @forelse($penyaluran as $index => $item)

                        <tr>

                            <td>

                                <strong>
                                    {{ $item->id_penyaluran }}
                                </strong>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}

                            </td>

                            <td>

                                {{ $item->jenisPupuk->nama_pupuk }}

                            </td>

                            <td>

                                {{ optional($item->kios)->nama_kios }}

                            </td>

                            {{-- HASIL PREDIKSI --}}
                            <td>

                                <strong>

                                    {{ number_format(
                                        optional($item->prediksi)->hasil_prediksi ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong> Kg

                            </td>

                            {{-- DATA AKTUAL --}}
                            <td>

                                @if($item->aktual !== null)

                                    <strong>

                                        {{ number_format(
                                            $item->aktual,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </strong> Kg

                                @else

                                    -

                                @endif

                            </td>

                            {{-- ERROR PREDIKSI --}}
                            <td class="text-center">

                                @if($item->error !== null)

                                    <strong>

                                        {{ number_format(
                                            $item->error,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </strong> %

                                @else

                                    -

                                @endif

                            </td>

                            {{-- PROPORSI --}}
                            <td class="text-center">

                                {{ number_format(
                                    $item->proporsi * 100,
                                    2,
                                    ',',
                                    '.'
                                ) }} %

                            </td>

                            {{-- JUMLAH PENYALURAN --}}
                            <td>

                                <strong>

                                    {{ number_format(
                                        $item->jumlah_penyaluran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </strong> Kg

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9">

                                <div class="empty-state">

                                    <i class="fa-solid fa-truck-fast"></i>

                                    <h3>
                                        Belum Ada Data Penyaluran
                                    </h3>

                                    <p>

                                        Silakan pilih periode kemudian klik
                                        <strong>Hitung Penyaluran</strong>.

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



<script>

document.querySelectorAll('.btn-edit').forEach(function(button){

    button.addEventListener('click', function(){

        let id = this.dataset.id;

        document.getElementById('edit_id').value = id;

        document.getElementById('edit_kios').value = this.dataset.kios;

        document.getElementById('edit_prediksi').value =
            Number(this.dataset.prediksi).toLocaleString('id-ID') + ' Kg';

        document.getElementById('edit_jumlah').value =
            this.dataset.jumlah;

        document.getElementById('formEdit').action =
            "/penyaluran/" + id;

        new bootstrap.Modal(
            document.getElementById('modalEdit')
        ).show();

    });

});

</script>
@endsection