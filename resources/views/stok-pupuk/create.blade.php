@extends('layouts.app')

@section('title', 'Tambah Stok Pupuk')

@section('content')

<div class="card">

    <h1>Tambah Data Stok Pupuk</h1>

    <br>

    <a href="{{ route('stok-pupuk.index') }}" class="btn btn-warning">
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

    <form action="{{ route('stok-pupuk.store') }}" method="POST">
        @csrf

        <label>Jenis Pupuk</label>
        <br>

        <select
            name="id_jenis"
            style="width:100%; padding:10px; margin-top:5px;"
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

        <br><br>

        <label>Periode</label>
        <br>
        <input type="month"
                name="periode"
                value="{{ old('periode') }}"
                style="width:100%; padding:10px; margin-top:5px;"
                required>

        <br><br>

        <label>Jumlah Stok (Kg)</label>
        <br>
        <input type="number"
               name="jumlah_stok"
               value="{{ old('jumlah_stok') }}"
               min="0"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

@endsection