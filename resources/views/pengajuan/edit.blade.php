@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')

<div class="card">

    <h1>Edit Data Pengajuan</h1>

    <br>

    <a href="{{ route('pengajuan.index') }}" class="btn btn-warning">
        Kembali
    </a>

    <br><br>

    @if ($errors->any())
        <div class="alert" style="background:#f8d7da; color:#721c24;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengajuan.update', $pengajuan->id_pengajuan) }}" method="POST">
        @csrf
        @method('PUT')

        <label>ID Pengajuan</label>
        <br>
        <input type="text"
               value="{{ $pengajuan->id_pengajuan }}"
               readonly
               style="width:100%; padding:10px; margin-top:5px; background:#e9ecef;">

        <br><br>

        <label>Kios</label>
        <br>

        <select name="id_kios"
                style="width:100%; padding:10px; margin-top:5px;">

            @foreach ($kios as $item)
                <option value="{{ $item->id_kios }}"
                    {{ old('id_kios', $pengajuan->id_kios) == $item->id_kios ? 'selected' : '' }}>
                    {{ $item->nama_kios }}
                </option>
            @endforeach

        </select>

        <br><br>

        <label>Periode</label>
        <br>

        <input type="month"
                name="periode"
                value="{{ old('periode', \Carbon\Carbon::parse($pengajuan->periode)->format('Y-m')) }}"
                style="width:100%; padding:10px; margin-top:5px;"
                required>

        <br><br>

        <label>Jumlah Pengajuan (Kg)</label>
        <br>

        <input type="number"
               step="0.01"
               min="0"
               name="jumlah_pengajuan"
               value="{{ old('jumlah_pengajuan', $pengajuan->jumlah_pengajuan) }}"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection