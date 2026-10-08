<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Kios;
use App\Models\HistorisPenyaluran;
use App\Models\Prediksi;
use App\Models\Penyaluran;
use App\Models\JenisPupuk;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // Mengambil daftar tahun dari data historis
        // ==========================================

        $daftarTahun = HistorisPenyaluran::select(
                DB::raw('YEAR(periode) as tahun')
            )
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Jika belum memilih tahun gunakan tahun terbaru
        $tahun = $request->tahun ?? $daftarTahun->first();

        // ==========================================
        // FILTER JENIS PUPUK
        // ==========================================

        // Ambil seluruh data jenis pupuk
        $daftarJenis = JenisPupuk::orderBy('nama_pupuk')->get();

        // Ambil jenis yang dipilih
        $idJenis = $request->id_jenis;

        // ==========================================
        // JUDUL FILTER
        // ==========================================

        $namaJenis = 'Semua Jenis';

        if ($idJenis) {

            $jenisAktif = $daftarJenis->firstWhere('id_jenis', $idJenis);

            if ($jenisAktif) {
                $namaJenis = $jenisAktif->nama_pupuk;
            }

        }

        // ==========================================
        // CARD DASHBOARD
        // ==========================================

        $jumlahKios = Kios::count();

        $queryHistoris = HistorisPenyaluran::whereYear('periode', $tahun);

        if ($idJenis) {
            $queryHistoris->where('id_jenis', $idJenis);
        }

        $jumlahHistoris = $queryHistoris->count();

        $queryPrediksi = Prediksi::whereYear('periode', $tahun);

        if ($idJenis) {
            $queryPrediksi->where('id_jenis', $idJenis);
        }

        $jumlahPrediksi = $queryPrediksi->count();

        $queryPenyaluran = Penyaluran::whereYear('periode', $tahun);

        if ($idJenis) {
            $queryPenyaluran->where('id_jenis', $idJenis);
        }

        $totalPenyaluran = $queryPenyaluran->sum('jumlah_penyaluran');

        // ==========================================
        // DATA GRAFIK HISTORIS PENYALURAN
        // ==========================================

        $queryGrafik = HistorisPenyaluran::select(
                DB::raw('MONTH(periode) as bulan'),
                DB::raw('SUM(jumlah_penyaluran) as total')
            )
            ->whereYear('periode', $tahun);

        // Jika memilih jenis pupuk tertentu
        if ($idJenis) {

            $queryGrafik->where('id_jenis', $idJenis);

        }

        $dataGrafik = $queryGrafik
            ->groupBy(DB::raw('MONTH(periode)'))
            ->orderBy(DB::raw('MONTH(periode)'))
            ->get()
            ->keyBy('bulan');

        $grafikHistoris = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            if ($dataGrafik->has($bulan)) {

                $grafikHistoris[] = [

                    'bulan'    => $bulan,
                    'total'    => (float) $dataGrafik[$bulan]->total,
                    'ada_data' => true

                ];

            } else {

                $grafikHistoris[] = [

                    'bulan'    => $bulan,
                    'total'    => 0,
                    'ada_data' => false

                ];

            }

        }

        // ==========================================
        // RINGKASAN HISTORIS
        // ==========================================

        // Hanya bulan yang benar-benar memiliki data
        $dataHistorisValid = collect($grafikHistoris)
            ->where('ada_data', true)
            ->values();

        // Total historis
        $totalHistoris = $dataHistorisValid->sum('total');

        // Jumlah bulan yang memiliki data
        $jumlahBulan = $dataHistorisValid->count();

        // Rata-rata historis
        $rataHistoris = $jumlahBulan > 0
            ? $totalHistoris / $jumlahBulan
            : 0;

        // Nama bulan
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // ==========================================
        // BULAN TERTINGGI
        // ==========================================

        if ($dataHistorisValid->isNotEmpty()) {

            $bulanTertinggi = $dataHistorisValid
                ->sortByDesc('total')
                ->first();

            $namaBulanTertinggi = $namaBulan[$bulanTertinggi['bulan']];

            $nilaiTertinggi = $bulanTertinggi['total'];

        } else {

            $namaBulanTertinggi = '-';
            $nilaiTertinggi = 0;

        }

        // ==========================================
        // BULAN TERENDAH
        // ==========================================

        if ($dataHistorisValid->isNotEmpty()) {

            $bulanTerendah = $dataHistorisValid
                ->sortBy('total')
                ->first();

            $namaBulanTerendah = $namaBulan[$bulanTerendah['bulan']];

            $nilaiTerendah = $bulanTerendah['total'];

        } else {

            $namaBulanTerendah = '-';
            $nilaiTerendah = 0;

        }

        // ==========================================
        // Kirim ke View
        // ==========================================

        return view('dashboard', compact(

            'daftarTahun',
            'tahun',

            'daftarJenis',
            'idJenis',
            'namaJenis',

            'jumlahKios',
            'jumlahHistoris',
            'jumlahPrediksi',
            'totalPenyaluran',

            'grafikHistoris',

            'totalHistoris',
            'rataHistoris',

            'namaBulanTertinggi',
            'nilaiTertinggi',

            'namaBulanTerendah',
            'nilaiTerendah'

        ));
    }
}