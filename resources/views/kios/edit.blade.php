@extends('layouts.app')

@section('title', 'Edit Kios')

@section('content')

<div class="card">

    <h1>Edit Data Kios</h1>

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

    <form action="{{ route('kios.update', $kios->id_kios) }}" method="POST">
        @csrf
        @method('PUT')

        <label>ID Kios</label>
        <br>
        <input type="text"
               value="{{ $kios->id_kios }}"
               readonly
               style="width:100%; padding:10px; margin-top:5px; background:#e9ecef;">

        <br><br>

        <label>Nama Kios</label>
        <br>
        <input type="text"
               name="nama_kios"
               value="{{ old('nama_kios', $kios->nama_kios) }}"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <label>Kecamatan</label>
        <br>
        <input type="text"
               name="kecamatan"
               value="{{ old('kecamatan', $kios->kecamatan) }}"
               style="width:100%; padding:10px; margin-top:5px;">

        <br><br>

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection