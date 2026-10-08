@extends('layouts.app')

@section('title', 'Edit Stok Pupuk')

@section('content')

<div class="card">

    <h1>Edit Data Stok Pupuk</h1>

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

    <form action="{{ route('stok-pupuk.update', $stokPupuk->id_stok) }}" method="POST">
        @csrf
        @method('PUT')

        <label>ID Stok</label>
        <br>
        <input type="text"
               value="{{ $stokPupuk->id_stok }}"
               readonly
               style="width:100%; padding:10px; margin-top:5px; background:#e9ecef;">

        <br><br>

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
                    {{ old('id_jenis', $stokPupuk->id_jenis) == $jenis->id_jenis ? 'selected' : '' }}>

                    {{ $jenis->nama_pupuk }}

                </option>

            @endforeach

        </select>

        <br><br>

        <label>Periode</label>
        <br>
        <input type="month"
                name="periode"
                value="{{ old('periode', \Carbon\Carbon::parse($stokPupuk->periode)->format('Y-m')) }}"
                style="width:100%; padding:10px; margin-top:5px;"
                required>

        <br><br>

        <label>Jumlah Stok (Kg)</label>
        <br>
        <input type="number"
               name="jumlah_stok"
               value="{{ old('jumlah_stok', $stokPupuk->jumlah_stok) }}"
               min="0"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection