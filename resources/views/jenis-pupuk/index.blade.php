@extends('layouts.app')

@section('title', 'Data Jenis Pupuk')

@section('content')

<!-- ===========================================
                PAGE HEADER
============================================ -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">

            Data Jenis Pupuk

        </h1>

        <p class="page-subtitle">

            Kelola data jenis pupuk bersubsidi.

        </p>

    </div>

    <div class="page-toolbar">

        <a href="{{ route('jenis-pupuk.create') }}" class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>

            Tambah Data

        </a>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari jenis pupuk...">

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

                        <th width="20%">ID Jenis</th>

                        <th>Nama Jenis Pupuk</th>

                        <th width="18%" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($jenisPupuk as $item)

                        <tr>

                            <td>

                                <span class="table-id">

                                    {{ $item->id_jenis }}

                                </span>

                            </td>

                            <td>

                                {{ $item->nama_pupuk }}

                            </td>

                            <td>

                                <div class="action-group">

                                    <a
                                        href="{{ route('jenis-pupuk.edit', $item->id_jenis) }}"
                                        class="btn btn-warning">

                                        <i class="fa-solid fa-pen-to-square"></i>

                                        Edit

                                    </a>

                                    <form
                                        action="{{ route('jenis-pupuk.destroy', $item->id_jenis) }}"
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

                            <td colspan="3">

                                <div class="empty-state">

                                    <i class="fa-solid fa-seedling"></i>

                                    <h3>

                                        Belum Ada Data Jenis Pupuk

                                    </h3>

                                    <p>

                                        Silakan tambahkan data jenis pupuk terlebih dahulu.

                                    </p>

                                    <a
                                        href="{{ route('jenis-pupuk.create') }}"
                                        class="btn btn-primary mt-2">

                                        <i class="fa-solid fa-plus"
                                            style="font-size:32px;margin:10px 0;"></i>

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