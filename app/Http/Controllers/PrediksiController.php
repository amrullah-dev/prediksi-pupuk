<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use App\Models\Prediksi;
use App\Models\JenisPupuk;
use App\Models\HistorisPenyaluran;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    public function index()
    {
        $prediksi = Prediksi::with([
            'kios',
            'jenisPupuk'
        ])
            ->orderByDesc('periode')
            ->orderBy('id_kios')
            ->get();

        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('prediksi.index', compact(
            'prediksi',
            'jenisPupuk'
        ));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'periode' => 'required|date',
            'id_jenis' => 'required|exists:jenis_pupuk,id_jenis',
        ]);

        $periode = $request->periode . '-01';
        $idJenis = $request->id_jenis;
        $jenisPupuk = JenisPupuk::findOrFail($idJenis);

                // Menentukan periode historis terakhir yang harus tersedia
        $periodeHistorisTerakhir = Carbon::parse($periode)
            ->subMonth()
            ->format('Y-m-01');

        // Cek apakah historis pada periode tersebut tersedia
        $historisTerakhirAda = HistorisPenyaluran::where('periode', $periodeHistorisTerakhir)
            ->exists();

        if (!$historisTerakhirAda) {

            return redirect()
                ->route('prediksi.index')
                ->with(
                    'error',
                    'Data historis sampai ' .
                    Carbon::parse($periodeHistorisTerakhir)->translatedFormat('F Y') .
                    ' belum tersedia. Silakan lengkapi data historis terlebih dahulu.'
                );
        }

        $kiosList = Kios::orderBy('nama_kios')->get();

        if ($kiosList->isEmpty()) {
            return redirect()
                ->route('prediksi.index')
                ->with('error', 'Belum terdapat data kios.');
        }

        DB::beginTransaction();

        try {

            $prediksiTerakhir = Prediksi::orderBy('id_prediksi', 'desc')->first();

            if ($prediksiTerakhir) {
                $nomor = (int) substr($prediksiTerakhir->id_prediksi, 3);
            } else {
                $nomor = 0;
            }

            $berhasil = 0;
            $dilewati = 0;
            $gagal = 0;

            $namaKiosGagal = [];

            foreach ($kiosList as $kios) {

                /*
                |--------------------------------------------------------------------------
                | Skip jika prediksi sudah ada
                |--------------------------------------------------------------------------
                */

                $sudahAda = Prediksi::where('id_kios', $kios->id_kios)
                    ->where('id_jenis', $idJenis)
                    ->where('periode', $periode)
                    ->exists();

                if ($sudahAda) {

                    $dilewati++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Ambil seluruh historis sebelum periode prediksi
                |--------------------------------------------------------------------------
                */

                $dataHistoris = HistorisPenyaluran::where('id_kios', $kios->id_kios)
                    ->where('id_jenis', $idJenis)
                    ->where('periode', '<=', $periodeHistorisTerakhir)
                    ->orderBy('periode')
                    ->get();
                
                // Validasi apakah data historis berurutan
                for ($i = 1; $i < $dataHistoris->count(); $i++) {

                    $periodeSebelumnya = Carbon::parse($dataHistoris[$i - 1]->periode);

                    $periodeSekarang = Carbon::parse($dataHistoris[$i]->periode);

                    $selisihBulan =
                        ($periodeSekarang->year - $periodeSebelumnya->year) * 12 +
                        ($periodeSekarang->month - $periodeSebelumnya->month);

                    if ($selisihBulan > 1) {

                        $kiosGagal[] =
                            $kios->nama_kios .
                            ' (Data historis tidak berurutan, setelah ' .
                            $periodeSebelumnya->translatedFormat('F Y') .
                            ')';

                        continue 2;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Minimal 3 data historis
                |--------------------------------------------------------------------------
                */

                if ($dataHistoris->count() < 3) {

                    $gagal++;

                    $namaKiosGagal[] = $kios->nama_kios;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Perhitungan Theta
                |--------------------------------------------------------------------------
                */

                $n = $dataHistoris->count();

                $sumT = 0;
                $sumY = 0;
                $sumT2 = 0;
                $sumTY = 0;

                foreach ($dataHistoris as $index => $item) {

                    $t = $index + 1;

                    $y = (float) $item->jumlah_penyaluran;

                    $sumT += $t;
                    $sumY += $y;
                    $sumT2 += pow($t, 2);
                    $sumTY += ($t * $y);
                }

                $penyebut = ($n * $sumT2) - pow($sumT, 2);

                if ($penyebut == 0) {

                    $gagal++;

                    $namaKiosGagal[] = $kios->nama_kios;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Menghitung koefisien tren (b)
                |--------------------------------------------------------------------------
                */

                $b = (($n * $sumTY) - ($sumT * $sumY)) / $penyebut;

                /*
                |--------------------------------------------------------------------------
                | Menghitung konstanta (a)
                |--------------------------------------------------------------------------
                */

                $a = ($sumY - ($b * $sumT)) / $n;

                /*
                |--------------------------------------------------------------------------
                | Theta Line θ = 0
                |--------------------------------------------------------------------------
                */

                $tBerikutnya = $n + 1;

                $z0 = $a + ($b * $tBerikutnya);

                /*
                |--------------------------------------------------------------------------
                | Theta Line θ = 2
                |--------------------------------------------------------------------------
                */

                $yTerakhir = (float) $dataHistoris->last()->jumlah_penyaluran;

                $ltTerakhir = $a + ($b * $n);

                $z2 = (2 * $yTerakhir) - $ltTerakhir;

                /*
                |--------------------------------------------------------------------------
                | Hasil Prediksi
                |--------------------------------------------------------------------------
                */

                $hasilPrediksi = ($z0 + $z2) / 2;

                if ($hasilPrediksi < 0) {
                    $hasilPrediksi = 0;
                }

                /*
                |--------------------------------------------------------------------------
                | Generate ID Prediksi
                |--------------------------------------------------------------------------
                */

                $nomor++;

                $idPrediksi = 'PRD' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

                Prediksi::create([

                    'id_prediksi' => $idPrediksi,
                    'id_kios' => $kios->id_kios,
                    'id_jenis' => $idJenis,
                    'periode' => $periode,
                    'hasil_prediksi' => round($hasilPrediksi, 2),

                ]);

                $berhasil++;
            }

            DB::commit();

            $pesan = "Prediksi <strong>{$jenisPupuk->nama_pupuk}</strong> periode <strong>" .
            Carbon::parse($periode)->translatedFormat('F Y') .
            "</strong> selesai diproses.<br><br>";

            $pesan .= "• {$berhasil} kios berhasil diprediksi.<br>";

            $pesan .= "• {$dilewati} kios sudah memiliki prediksi sehingga dilewati.<br>";

            $pesan .= "• {$gagal} kios gagal diprediksi karena historis kurang dari 3 bulan atau data tidak valid.";

            if ($gagal > 0) {

                $pesan .= "<br><br><strong>Kios yang belum memenuhi syarat :</strong><br>";

                foreach ($namaKiosGagal as $nama) {

                    $pesan .= "- {$nama}<br>";
                }
            }

            return redirect()
                ->route('prediksi.index')
                ->with('success', $pesan);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('prediksi.index')
                ->with('error', 'Terjadi kesalahan : ' . $e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $prediksi = Prediksi::findOrFail($id);

            $prediksi->delete();

            return redirect()
                ->route('prediksi.index')
                ->with('success', 'Data prediksi berhasil dihapus.');

        } catch (QueryException $e) {

            return redirect()
                ->route('prediksi.index')
                ->with(
                    'error',
                    'Data prediksi tidak dapat dihapus karena masih digunakan pada data penyaluran.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->route('prediksi.index')
                ->with(
                    'error',
                    'Terjadi kesalahan saat menghapus data prediksi.'
                );
        }
    }
}