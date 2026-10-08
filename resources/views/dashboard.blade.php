@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- ===========================================
                PAGE HEADER
=========================================== -->

<div class="page-header">

    <div class="page-title-group">

        <h1 class="page-title">

            Dashboard

        </h1>

        <p class="page-subtitle">

            Ringkasan informasi sistem kebutuhan distribusi pupuk.

        </p>

    </div>

    <!-- ===========================================
                    FLASH MESSAGE
    =========================================== -->

    @if(session('success'))

    <div class="alert alert-success">

        <i class="fa-solid fa-circle-check"></i>

        <span>

            {{ session('success') }}

        </span>

        <button class="alert-close">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    @endif


    @if(session('error'))

    <div class="alert alert-warning">

        <i class="fa-solid fa-triangle-exclamation"></i>

        <span>

            {{ session('error') }}

        </span>

        <button class="alert-close">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    @endif

   <div class="page-toolbar">

        <form
            action="{{ route('dashboard') }}"
            method="GET"
            class="d-flex align-items-end gap-3 flex-wrap">

            {{-- Filter Tahun --}}
            <div>

                <label
                    for="tahun"
                    class="form-label fw-semibold mb-2">

                    Tahun

                </label>

                <select
                    id="tahun"
                    name="tahun"
                    class="form-select"
                    onchange="this.form.submit()">

                    @foreach($daftarTahun as $item)

                        <option
                            value="{{ $item }}"
                            {{ $tahun == $item ? 'selected' : '' }}>

                            {{ $item }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Filter Jenis Pupuk --}}
            <div>

                <label
                    for="id_jenis"
                    class="form-label fw-semibold mb-2">

                    Jenis Pupuk

                </label>

                <select
                    id="id_jenis"
                    name="id_jenis"
                    class="form-select"
                    onchange="this.form.submit()">

                    <option value=""
                        {{ empty($idJenis) ? 'selected' : '' }}>

                        Semua Jenis

                    </option>

                    @foreach($daftarJenis as $jenis)

                        <option
                            value="{{ $jenis->id_jenis }}"
                            {{ $idJenis == $jenis->id_jenis ? 'selected' : '' }}>

                            {{ $jenis->nama_pupuk }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

    </div>

</div>

<!-- ===========================================
            STATISTIK DASHBOARD
=========================================== -->

<div class="dashboard-stats">

    <!-- =========================
         Jumlah Kios
    ========================== -->
    <div class="card stat-card">

        <div class="card-body">

            <div class="stat-header">

                <div class="stat-icon bg-success">
                    <i class="fa-solid fa-store"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Jumlah Kios
                    </div>

                    <div class="stat-value">
                        {{ number_format($jumlahKios) }}
                    </div>

                </div>

            </div>

            <div class="stat-description">
                Total kios yang terdaftar pada sistem.
            </div>

        </div>

    </div>

    <!-- =========================
         Data Historis
    ========================== -->
    <div class="card stat-card">

        <div class="card-body">

            <div class="stat-header">

                <div class="stat-icon bg-primary">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Data Historis
                    </div>

                    <div class="stat-value">
                        {{ number_format($jumlahHistoris) }}
                    </div>

                </div>

            </div>

            <div class="stat-description">
                Tahun {{ $tahun }}
            </div>

        </div>

    </div>

    <!-- =========================
         Data Prediksi
    ========================== -->
    <div class="card stat-card">

        <div class="card-body">

            <div class="stat-header">

                <div class="stat-icon bg-warning">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-title">
                        Data Prediksi
                    </div>

                    <div class="stat-value">
                        {{ number_format($jumlahPrediksi) }}
                    </div>

                </div>

            </div>

            <div class="stat-description">
                Tahun {{ $tahun }}
            </div>

        </div>

    </div>

    

</div>

<!-- ===========================================
                GRAFIK
=========================================== -->

<div class="card mt-3">

    <div class="card-header">

        <div>

            <div class="card-title">

                <i class="fa-solid fa-chart-line"></i>

                Grafik Historis Penyaluran 

            </div>

            <div class="card-subtitle">

                Total historis penyaluran pupuk seluruh kios
                berdasarkan tahun {{ $tahun }} • {{ $namaJenis }}.

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="chart-container">

            <canvas id="historisChart"></canvas>

        </div>

    </div>

</div>

<!-- ===========================================
            RINGKASAN HISTORIS
=========================================== -->

<div class="dashboard-summary">

    <!-- Total Historis -->

    <div class="card summary-card">

        <div class="card-body">

            <div class="summary-header">

                <div class="summary-icon" style="width: 48px; height: 48px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">

                    <i class="fa-solid fa-boxes-stacked"></i>

                </div>

                <div>

                    <div class="summary-title">

                        Total Historis

                    </div>

                    <div class="summary-subtitle">

                        Akumulasi historis penyaluran.

                    </div>

                </div>

            </div>

            <div class="summary-value">

                {{ number_format($totalHistoris,0,',','.') }} Kg

            </div>

            <div class="summary-footer">

                Tahun {{ $tahun }}

            </div>

        </div>

    </div>



    <!-- Rata-rata -->

    <div class="card summary-card">

        <div class="card-body">

            <div class="summary-header">

                <div class="summary-icon" style="width: 48px; height: 48px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">

                    <i class="fa-solid fa-chart-column" ></i>

                </div>

                <div>

                    <div class="summary-title">

                        Rata-rata Per Bulan

                    </div>

                    <div class="summary-subtitle">

                        Berdasarkan bulan yang memiliki data.

                    </div>

                </div>

            </div>

            <div class="summary-value">

                {{ number_format($rataHistoris,0,',','.') }} Kg

            </div>

            <div class="summary-footer">

                Tahun {{ $tahun }}

            </div>

        </div>

    </div>



    <!-- Bulan Tertinggi -->

    <div class="card summary-card">

        <div class="card-body">

            <div class="summary-header">

                <div class="summary-icon">

                    <i class="fa-solid fa-arrow-trend-up"></i>

                </div>

                <div>

                    <div class="summary-title">

                        Bulan Tertinggi

                    </div>

                    <div class="summary-subtitle">

                        Penyaluran terbesar.

                    </div>

                </div>

            </div>

            <div class="summary-value">

                {{ $namaBulanTertinggi }}

            </div>

            <div class="summary-footer">

                {{ number_format($nilaiTertinggi,0,',','.') }} Kg

            </div>

        </div>

    </div>



    <!-- Bulan Terendah -->

    <div class="card summary-card">

        <div class="card-body">

            <div class="summary-header">

                <div class="summary-icon">

                    <i class="fa-solid fa-arrow-trend-down"></i>

                </div>

                <div>

                    <div class="summary-title">

                        Bulan Terendah

                    </div>

                    <div class="summary-subtitle">

                        Penyaluran terkecil.

                    </div>

                </div>

            </div>

            <div class="summary-value">

                {{ $namaBulanTerendah }}

            </div>

            <div class="summary-footer">

                {{ number_format($nilaiTerendah,0,',','.') }} Kg

            </div>

        </div>

    </div>

</div>

<!-- ===========================================
                CHART JS
=========================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const labels = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    ];

    const historis = @json($grafikHistoris);

    const dataHistoris = historis.map(item => Number(item.total));

    const ctx = document.getElementById('historisChart');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Historis Penyaluran (Kg)',

                data: dataHistoris,

                borderColor: '#16a34a',

                backgroundColor: 'rgba(22,163,74,.12)',

                fill: true,

                borderWidth: 3,

                tension: 0.4,

                pointRadius: 5,

                pointHoverRadius: 7,

                pointBackgroundColor: '#16a34a',

                pointBorderColor: '#ffffff',

                pointBorderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                mode: 'index',

                intersect: false

            },

            plugins: {

                legend: {

                    display: true,

                    position: 'top',

                    labels: {

                        usePointStyle: true,

                        pointStyle: 'circle',

                        padding: 20,

                        font: {

                            size: 13

                        }

                    }

                },

                tooltip: {

                    backgroundColor: '#1f2937',

                    titleColor: '#ffffff',

                    bodyColor: '#ffffff',

                    padding: 12,

                    displayColors: false,

                    callbacks: {

                        label: function (context) {

                            return context.dataset.label + ' : ' +
                                Number(context.parsed.y).toLocaleString('id-ID') +
                                ' Kg';

                        }

                    }

                }

            },

            scales: {

                x: {

                    grid: {

                        display: false

                    },

                    ticks: {

                        color: '#6b7280'

                    }

                },

                y: {

                    beginAtZero: true,

                    ticks: {

                        color: '#6b7280',

                        callback: function (value) {

                            return Number(value).toLocaleString('id-ID') + ' Kg';

                        }

                    },

                    grid: {

                        color: '#e5e7eb'

                    }

                }

            }

        }

    });

});

</script>
@endsection