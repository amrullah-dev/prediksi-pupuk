@extends('layouts.app')

@section('title', 'Tambah Kios')

@section('content')

<div class="card">

    <h1>Tambah Data Kios</h1>

    <br>

    <a href="{{ route('kios.index') }}" class="btn btn-warning">
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

    <form action="{{ route('kios.store') }}" method="POST">
        @csrf

        <label>Nama Kios</label>
        <br>
        <input type="text"
               name="nama_kios"
               value="{{ old('nama_kios') }}"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <label>Kecamatan</label>
        <br>
        <input type="text"
               name="kecamatan"
               value="{{ old('kecamatan') }}"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

@endsection