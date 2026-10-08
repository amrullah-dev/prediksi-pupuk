@extends('layouts.app')

@section('title', 'Data Kios')

@section('content')

<!-- ===========================================
                PAGE HEADER
============================================ -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">
            Data Kios
        </h1>

        <p class="page-subtitle">
            Kelola data kios pupuk bersubsidi.
        </p>

    </div>

    <div class="page-toolbar">

        <a href="{{ route('kios.create') }}" class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>

            Tambah Data

        </a>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari data kios...">

        </div>

    </div>

</div>

<!-- ===========================================
                    CARD
============================================ -->

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

                        <th width="15%">ID Kios</th>

                        <th>Nama Kios</th>

                        <th>Kecamatan</th>

                        <th width="18%" class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($kios as $item)

                        <tr>

                            <td>

                                <span class="table-id">

                                    {{ $item->id_kios }}

                                </span>

                            </td>

                            <td>

                                {{ $item->nama_kios }}

                            </td>

                            <td>

                                {{ $item->kecamatan }}

                            </td>

                            <td>

                                <div class="action-group">

                                    <a
                                        href="{{ route('kios.edit', $item->id_kios) }}"
                                        class="btn btn-warning">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('kios.destroy', $item->id_kios) }}"
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

                            <td colspan="4">

                                <div class="empty-state">

                                    <i class="fa-solid fa-folder-open"></i>

                                    <h3>

                                        Belum Ada Data Kios

                                    </h3>

                                    <p>

                                        Silakan tambahkan data kios terlebih dahulu.

                                    </p>

                                    <a
                                        href="{{ route('kios.create') }}"
                                        class="btn btn-primary mt-2">

                                        <i class="fa-solid fa-plus" style="font-size: 32px; margin: 10px 0px; "></i>

                                        Tambah Data

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