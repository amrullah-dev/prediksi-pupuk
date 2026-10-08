@extends('layouts.app')

@section('title', 'Data Pengajuan')

@section('content')

<div class="card">

    <h1>Data Pengajuan</h1>

    <br>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">
        Tambah Pengajuan
    </a>

    <table>
        <tr>
            <th>ID Pengajuan</th>
            <th>Nama Kios</th>
            <th>Periode</th>
            <th>Jumlah Pengajuan</th>
            <th>Aksi</th>
        </tr>

        @forelse($pengajuan as $item)
        <tr>
            <td>{{ $item->id_pengajuan }}</td>
            <td>{{ $item->kios->nama_kios }}</td>
            <td>{{ \Carbon\Carbon::parse($item->periode)->format('F Y') }}</td>
            <td>{{ number_format($item->jumlah_pengajuan, 0, ',', '.') }} Kg</td>
            <td>
                <a href="{{ route('pengajuan.edit', $item->id_pengajuan) }}"
                class="btn btn-warning">
                    Edit
                </a>

                <form action="{{ route('pengajuan.destroy', $item->id_pengajuan) }}"
                    method="POST"
                    style="display:inline;"
                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">
                Belum ada data pengajuan.
            </td>
        </tr>
        @endforelse

    </table>

</div>

@endsection