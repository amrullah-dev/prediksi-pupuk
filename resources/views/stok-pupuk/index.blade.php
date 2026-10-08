@extends('layouts.app')

@section('title', 'Stok Pupuk')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Data Stok Pupuk
        </h1>

        <p class="page-subtitle">
            Kelola data stok pupuk bersubsidi yang tersedia.
        </p>

    </div>

    <div class="page-toolbar">

        <a href="{{ route('stok-pupuk.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>

            Tambah Stok

        </a>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari data stok...">

        </div>

    </div>

</div>

<!-- ===========================================
                    CARD
=========================================== -->

<div class="card">

    <div class="card-body">

        {{-- Alert Success --}}
        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        {{-- Alert Error --}}
        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        <div class="table-responsive">

            <table class="table-modern" id="dataTable">

                <thead>

                    <tr>

                        <th width="15%">ID Stok</th>
                        <th>Jenis Pupuk</th>
                        <th width="20%">Periode</th>
                        <th>Jumlah Stok</th>
                        <th width="18%" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($stokPupuk as $item)

                        <tr>

                            <td>

                                <span class="table-id">

                                    {{ $item->id_stok }}

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

                                    {{ number_format($item->jumlah_stok, 0, ',', '.') }}

                                </strong> Kg

                            </td>

                            <td>

                                <div class="action-group">

                                    <a href="{{ route('stok-pupuk.edit', $item->id_stok) }}"
                                       class="btn btn-warning">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('stok-pupuk.destroy', $item->id_stok) }}"
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

                            <td colspan="5">

                                <div class="empty-state">

                                    <i class="fa-solid fa-warehouse"></i>

                                    <h3>

                                        Belum Ada Data Stok

                                    </h3>

                                    <p>

                                        Silakan tambahkan data stok pupuk terlebih dahulu.

                                    </p>

                                    <a href="{{ route('stok-pupuk.create') }}"
                                       class="btn btn-primary mt-2 ">

                                        <i class="fa-solid fa-plus" style="font-size: 32px; margin: 10px 0px; "></i>

                                        Tambah Stok

                                    </a>

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