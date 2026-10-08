<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>

        Laporan Penyaluran

    </title>

    <style>

        body{

            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#000;

        }

        .kop{

            width:100%;
            margin-bottom:15px;

        }

        .judul{

            text-align:center;
            margin-bottom:20px;

        }

        .judul h2{

            margin:0;
            font-size:18px;

        }

        .judul p{

            margin-top:5px;

        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        table th{

            border:1px solid #000;
            background:#efefef;
            padding:8px;

        }

        table td{

            border:1px solid #000;
            padding:8px;

        }

        .text-center{

            text-align:center;

        }

        .text-right{

            text-align:right;

        }

        .footer{

            margin-top:35px;
            text-align:right;

        }

    </style>

</head>

<body>

    <img
        src="{{ public_path('images/kop-mahatani.png') }}"
        class="kop">

    <div class="judul">

        <h2>

        @if($jenis == 'historis')

            LAPORAN HISTORIS PENYALURAN

        @elseif($jenis == 'prediksi')

            LAPORAN HASIL PREDIKSI

        @elseif($jenis == 'safety')

            LAPORAN SAFETY STOK

        @elseif($jenis == 'penyaluran')

            LAPORAN PENYALURAN PUPUK BERSUBSIDI

        @endif

        </h2>

        <p>

        <strong>Periode :</strong>

        @if($periode)

            {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}

        @else

            Semua Periode

        @endif

        </p>

    </div>

    <table>

        @if($jenis == 'penyaluran')

            <thead>

                <tr>

                    <th>No</th>
                    <th>ID Penyaluran</th>
                    <th>Periode</th>
                    <th>Jenis Pupuk</th>
                    <th>Nama Kios</th>
                    <th>Prediksi</th>
                    <th>Proporsi</th>
                    <th>Penyaluran</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->id_penyaluran }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td>

                    <td>{{ $item->jenisPupuk->nama_pupuk }}</td>

                    <td>{{ $item->kios->nama_kios }}</td>

                    <td>{{ number_format($item->prediksi->hasil_prediksi,0,',','.') }} Kg</td>

                    <td>{{ number_format($item->proporsi * 100, 2, ',', '.') }} %</td>

                    <td>{{ number_format($item->jumlah_penyaluran,0,',','.') }} Kg</td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        @elseif($jenis == 'prediksi')

            <thead>

                <tr>

                    <th>No</th>
                    <th>ID Prediksi</th>
                    <th>Periode</th>
                    <th>Nama Kios</th>
                    <th>Jenis Pupuk</th>
                    <th>Hasil Prediksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->id_prediksi }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td>

                    <td>{{ $item->kios->nama_kios }}</td>

                    <td>{{ $item->jenisPupuk->nama_pupuk }}</td>

                    <td class="text-right">

                        {{ number_format($item->hasil_prediksi,0,',','.') }} Kg

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        @elseif($jenis == 'safety')

            <thead>

                <tr>

                    <th>No</th>
                    <th>ID Safety</th>
                    <th>Periode</th>
                    <th>Jumlah Stok</th>
                    <th>Safety Stok</th>
                    <th>Siap Salur</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->id_safety }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td>

                    <td class="text-right">

                        {{ number_format($item->stokPupuk->jumlah_stok,0,',','.') }} Kg

                    </td>

                    <td class="text-right">

                        {{ number_format($item->safety_stok,0,',','.') }} Kg

                    </td>

                    <td class="text-right">

                        {{ number_format($item->siap_salur,0,',','.') }} Kg

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        @elseif($jenis == 'historis')

            <thead>

                <tr>

                    <th>No</th>
                    <th>ID Historis</th>
                    <th>Periode</th>
                    <th>Nama Kios</th>
                    <th>Jenis Pupuk</th>
                    <th>Jumlah Penyaluran</th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->id_historis }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}</td>

                    <td>{{ $item->kios->nama_kios }}</td>

                    <td>{{ $item->jenisPupuk->nama_pupuk }}</td>

                    <td class="text-right">

                        {{ number_format($item->jumlah_penyaluran,0,',','.') }} Kg

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        @endif

    </table>

    <div class="footer">

        <p>

            Lebak,

            {{ now()->translatedFormat('d F Y') }}

        </p>

        <br><br><br>


    </div>

</body>

</html>