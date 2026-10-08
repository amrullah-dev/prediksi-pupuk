<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorisPenyaluran;
use App\Models\Penyaluran;
use App\Models\Prediksi;
use App\Models\SafetyStok;
use App\Models\JenisPupuk;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $jenis = null;
        $periode = null;
        $idJenis = null;

        $data = collect();

        $daftarJenis = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('laporan.index', compact(
            'jenis',
            'periode',
            'idJenis',
            'daftarJenis',
            'data'
        ));
    }

    private function getLaporanData($jenis, $idJenis, $periode)
    {
        switch ($jenis) {

            case 'penyaluran':

                $query = Penyaluran::with([
                    'kios',
                    'prediksi',
                    'safetyStok',
                    'jenisPupuk'
                ]);

                if (!empty($periode)) {
                    $query->whereMonth('periode', date('m', strtotime($periode)))
                        ->whereYear('periode', date('Y', strtotime($periode)));
                }

                if (!empty($idJenis)) {
                    $query->where('id_jenis', $idJenis);
                }

                return $query->orderBy('periode')
                            ->orderBy('id_penyaluran')
                            ->get();

            case 'prediksi':

                $query = Prediksi::with([
                    'kios',
                    'jenisPupuk'
                ]);

                if (!empty($periode)) {
                    $query->whereMonth('periode', date('m', strtotime($periode)))
                        ->whereYear('periode', date('Y', strtotime($periode)));
                }

                if (!empty($idJenis)) {
                    $query->where('id_jenis', $idJenis);
                }

                return $query->orderBy('periode')
                            ->orderBy('id_prediksi')
                            ->get();

            case 'safety':

                $query = SafetyStok::with('stokPupuk');

                if (!empty($periode)) {
                    $query->whereMonth('periode', date('m', strtotime($periode)))
                        ->whereYear('periode', date('Y', strtotime($periode)));
                }

                return $query->orderBy('periode')
                            ->orderBy('id_safety')
                            ->get();

            case 'historis':

                $query = HistorisPenyaluran::with([
                    'kios',
                    'jenisPupuk'
                ]);

                if (!empty($periode)) {
                    $query->whereMonth('periode', date('m', strtotime($periode)))
                        ->whereYear('periode', date('Y', strtotime($periode)));
                }

                if (!empty($idJenis)) {
                    $query->where('id_jenis', $idJenis);
                }

                return $query->orderBy('periode')
                            ->orderBy('id_historis')
                            ->get();
            default:

                return collect();
        }
    }

    public function tampilkan(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'id_jenis' => 'nullable',
            'periode' => 'nullable',
        ]);

        $jenis = $request->jenis;
        $idJenis = $request->id_jenis;
        $periode = $request->filled('periode')
            ? $request->periode . '-01'
            : null;

        $data = $this->getLaporanData(
            $jenis,
            $idJenis,
            $periode
        );

        $daftarJenis = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('laporan.index', compact(
            'jenis',
            'periode',
            'idJenis',
            'daftarJenis',
            'data'
        ));
    }

    public function print(Request $request)
    {
        $jenis = $request->jenis;
        $idJenis = $request->id_jenis;
        $periode = $request->filled('periode')
            ? $request->periode . '-01'
            : null;

        $data = $this->getLaporanData(
            $jenis,
            $idJenis,
            $periode
        );

        return view('laporan.print', compact(
            'jenis',
            'periode',
            'data'
        ));
    }

    public function pdf(Request $request)
    {
        $jenis = $request->jenis;
        $idJenis = $request->id_jenis;
        $periode = $request->filled('periode')
            ? $request->periode . '-01'
            : null;

        $data = $this->getLaporanData(
            $jenis,
            $idJenis,
            $periode
        );

        $pdf = Pdf::loadView(
            'laporan.pdf',
            compact(
                'jenis',
                'periode',
                'data'
            )
        );

        $pdf->setPaper('A4', 'portrait');

        $namaPeriode = $periode
            ? \Carbon\Carbon::parse($periode)->translatedFormat('F-Y')
            : 'Semua-Periode';

        return $pdf->download(
            'Laporan-' .
            ucfirst($jenis) .
            '-' .
            $namaPeriode .
            '.pdf'
        );
    }

    public function excel(Request $request)
    {
        $jenis = $request->jenis;
        $idJenis = $request->id_jenis;
        $periode = $request->filled('periode')
            ? $request->periode . '-01'
            : null;

        $data = $this->getLaporanData(
            $jenis,
            $idJenis,
            $periode
        );

        $namaPeriode = $periode
            ? \Carbon\Carbon::parse($periode)->translatedFormat('F-Y')
            : 'Semua-Periode';

        return Excel::download(
            new LaporanExport($data, $jenis),
            'Laporan-' .
            ucfirst($jenis) .
            '-' .
            $namaPeriode .
            '.xlsx'
        );
    }
}