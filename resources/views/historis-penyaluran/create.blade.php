
@extends('layouts.app')

@section('title', 'Tambah Historis Penyaluran')

@section('content')

<div class="card">

    <h1>Tambah Data Historis Penyaluran</h1>

    <br>


    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert" style="background:#f8d7da; color:#721c24;">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('historis-penyaluran.index') }}" class="btn btn-warning">
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

    <form action="{{ route('historis-penyaluran.store') }}" method="POST">
        @csrf

        <label>Kios</label>
        <br>
        <select name="id_kios"
                style="width:100%; padding:10px; margin-top:5px;"
                required>

            <option value="">-- Pilih Kios --</option>

            @foreach($kios as $item)
                <option value="{{ $item->id_kios }}"
                    {{ old('id_kios') == $item->id_kios ? 'selected' : '' }}>
                    {{ $item->nama_kios }}
                </option>
            @endforeach

        </select>

        <br><br>

        <label>Jenis Pupuk</label>
        <br>
        <select
            name="id_jenis"
            style="width:100%; padding:10px; margin-top:5px;"
            required>

            <option value="">-- Pilih Jenis Pupuk --</option>

            @foreach($jenisPupuk as $item)

                <option
                    value="{{ $item->id_jenis }}"
                    {{ old('id_jenis')==$item->id_jenis ? 'selected' : '' }}>

                    {{ $item->nama_pupuk }}

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

        <label>Jumlah Penyaluran (Kg)</label>
        <br>
        <input type="number"
               name="jumlah_penyaluran"
               value="{{ old('jumlah_penyaluran') }}"
               min="0"
               step="0.01"
               style="width:100%; padding:10px; margin-top:5px;"
               required>

        <br><br>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

@endsection

