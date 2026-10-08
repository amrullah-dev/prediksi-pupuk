<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use App\Models\Prediksi;
use App\Models\SafetyStok;
use App\Models\JenisPupuk;
use App\Models\HistorisPenyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyaluranController extends Controller
{
    /**
     * Menampilkan halaman penyaluran.
     */
    public function index()
    {
        $penyaluran = Penyaluran::with([
                'kios',
                'prediksi',
                'jenisPupuk'
            ])
            ->orderByDesc('periode')
            ->orderBy('id_jenis')
            ->orderBy('id_kios')
            ->get();

        foreach ($penyaluran as $item) {

            $prediksi = optional($item->prediksi)->hasil_prediksi;

            $aktual = HistorisPenyaluran::where('id_kios', $item->id_kios)
                ->where('id_jenis', $item->id_jenis)
                ->where('periode', $item->periode)
                ->value('jumlah_penyaluran');

            $item->aktual = $aktual;

            if ($aktual !== null && $aktual > 0 && $prediksi !== null) {

                $item->error = abs($aktual - $prediksi) / $aktual * 100;

            } else {

                $item->error = null;

            }
        }

        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('penyaluran.index', [
            'penyaluran'     => $penyaluran,
            'periodeDipilih' => null,
            'jenisPupuk'     => $jenisPupuk,
        ]);
    }

    /**
     * Generate ID Penyaluran.
     * Contoh:
     * PNY001
     * PNY002
     */
    private function generateIdPenyaluran()
    {
        $last = Penyaluran::orderBy('id_penyaluran', 'desc')->first();

        if (!$last) {
            return 'PNY001';
        }

        $nomor = (int) substr($last->id_penyaluran, 3);

        $nomor++;

        return 'PNY' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Hitung Penyaluran
     */
    public function hitung(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'id_jenis' => 'required|exists:jenis_pupuk,id_jenis',
        ]);

        $periode = $request->periode . '-01';

        $idJenis = $request->id_jenis;

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Prediksi
        |--------------------------------------------------------------------------
        */

        $prediksi = Prediksi::with('kios')
            ->where('periode', $periode)
            ->where('id_jenis', $idJenis)
            ->orderBy('id_kios')
            ->get();

        if ($prediksi->isEmpty()) {

            return redirect()
                ->route('penyaluran.index')
                ->with(
                    'error',
                    'Data prediksi pada periode tersebut belum tersedia.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Safety Stock
        |--------------------------------------------------------------------------
        */

        $safety = SafetyStok::where('periode', $periode)
            ->where('id_jenis', $idJenis)
            ->first();

        if (!$safety) {

            return redirect()
                ->route('penyaluran.index')
                ->with(
                    'error',
                    'Data safety stok pada periode tersebut belum tersedia.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung Total Prediksi
        |--------------------------------------------------------------------------
        */

        $totalPrediksi = $prediksi->sum('hasil_prediksi');

        if ($totalPrediksi <= 0) {

            return redirect()
                ->route('penyaluran.index')
                ->with(
                    'error',
                    'Total hasil prediksi tidak boleh bernilai nol.'
                );
        }

        DB::beginTransaction();

        try {

            $totalSiapSalur = $safety->siap_salur;
            $totalTersalur = 0;
            $totalData = $prediksi->count();

            foreach ($prediksi as $index => $item) {

                /*
                |--------------------------------------------------------------------------
                | Hitung Proporsi
                |--------------------------------------------------------------------------
                */

                $proporsi = $item->hasil_prediksi / $totalPrediksi;

                /*
                |--------------------------------------------------------------------------
                | Hitung Jumlah Penyaluran
                |--------------------------------------------------------------------------
                */

                // Untuk kios terakhir, gunakan sisa stok
                if ($index == ($totalData - 1)) {

                    $jumlahPenyaluran = $totalSiapSalur - $totalTersalur;

                } else {

                    $jumlahPenyaluran = round($proporsi * $totalSiapSalur);

                    $totalTersalur += $jumlahPenyaluran;
                }

                /*
                |--------------------------------------------------------------------------
                | Cek apakah data sudah ada
                |--------------------------------------------------------------------------
                */

                $penyaluran = Penyaluran::where('periode', $periode)
                    ->where('id_kios', $item->id_kios)
                    ->where('id_jenis', $idJenis)
                    ->first();

                if ($penyaluran) {

                    $penyaluran->update([
                        'id_prediksi'       => $item->id_prediksi,
                        'id_safety'         => $safety->id_safety,
                        'id_jenis'          => $idJenis,
                        'proporsi'          => $proporsi,
                        'jumlah_penyaluran' => $jumlahPenyaluran,
                    ]);

                } else {

                    Penyaluran::create([
                        'id_penyaluran'     => $this->generateIdPenyaluran(),
                        'id_kios'           => $item->id_kios,
                        'id_prediksi'       => $item->id_prediksi,
                        'id_safety'         => $safety->id_safety,
                        'id_jenis'          => $idJenis,
                        'periode'           => $periode,
                        'proporsi'          => $proporsi,
                        'jumlah_penyaluran' => $jumlahPenyaluran,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('penyaluran.index')
                ->with(
                    'success',
                    'Data penyaluran berhasil dihitung dan disimpan.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('penyaluran.index')
                ->with(
                    'error',
                    'Terjadi kesalahan: ' . $e->getMessage()
                );
        }
    }
        /**
     * Update jumlah penyaluran.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_penyaluran' => [
                'required',
                'integer',
                'min:0'
            ],
        ], [
            'jumlah_penyaluran.required' => 'Jumlah penyaluran wajib diisi.',
            'jumlah_penyaluran.integer'  => 'Jumlah penyaluran harus berupa angka.',
            'jumlah_penyaluran.min'      => 'Jumlah penyaluran tidak boleh kurang dari 0.',
        ]);

        $penyaluran = Penyaluran::where('id_penyaluran', $id)->firstOrFail();

        $penyaluran->update([
            'jumlah_penyaluran' => $request->jumlah_penyaluran,
        ]);

        return redirect()
            ->route('penyaluran.index')
            ->with(
                'success',
                'Jumlah penyaluran berhasil diperbarui.'
            );
    }

    public function edit($id)
    {
        $penyaluran = Penyaluran::with([
            'kios',
            'prediksi'
        ])
        ->where('id_penyaluran', $id)
        ->firstOrFail();

        return view('penyaluran.edit', compact('penyaluran'));
    }

    
    public function destroyAll()
    {
        Penyaluran::query()->delete();

        return redirect()
            ->route('penyaluran.index')
            ->with(
                'success',
                'Seluruh data penyaluran berhasil dihapus.'
            );
    }
}
            

            