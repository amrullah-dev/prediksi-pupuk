<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use App\Models\SafetyStok;
use App\Models\StokPupuk;
use App\Models\JenisPupuk;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SafetyStokController extends Controller
{
    public function index()
    {
        $data = SafetyStok::with([
            'stokPupuk',
            'jenisPupuk'
        ])
        ->orderByDesc('periode')
        ->orderBy('id_jenis')
        ->get();

        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('safety-stok.index', compact(
            'data',
            'jenisPupuk'
        ));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'periode' => 'required',
            'id_jenis' => 'required|exists:jenis_pupuk,id_jenis',
        ]);

        $periode = $request->periode . '-01';

        $idJenis = $request->id_jenis;

        // Cek apakah data sudah ada
        $cek = SafetyStok::where('periode', $periode)
            ->where('id_jenis', $idJenis)
            ->exists();

        if ($cek) {
            return redirect()
                ->route('safety-stok.index')
                ->with('error', 'Safety stok untuk periode tersebut sudah tersedia.');
        }

        // Ambil semua prediksi pada periode tersebut
        $prediksi = Prediksi::where('periode', $periode)
            ->where('id_jenis', $idJenis)
            ->get();

        if ($prediksi->isEmpty()) {
            return redirect()
                ->route('safety-stok.index')
                ->with('error', 'Data prediksi untuk periode tersebut belum tersedia.');
        }

        // Hitung D_max dan D_avg
        $dMax = $prediksi->max('hasil_prediksi');

        $dAvg = $prediksi->avg('hasil_prediksi');

        $safetyStok = $dMax - $dAvg;

        // Ambil data stok pada periode yang sama
        $stok = StokPupuk::where('periode', $periode)
            ->where('id_jenis', $idJenis)
            ->first();

        if (!$stok) {
            return redirect()
                ->route('safety-stok.index')
                ->with('error', 'Data stok pupuk untuk periode tersebut belum tersedia.');
        }

        $siapSalur = $stok->jumlah_stok - $safetyStok;

        // Generate ID
        $terakhir = SafetyStok::orderBy('id_safety', 'desc')->first();

        if ($terakhir) {
            $nomor = (int) substr($terakhir->id_safety, 2) + 1;
        } else {
            $nomor = 1;
        }

        $idSafety = 'SS' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        SafetyStok::create([
            'id_safety' => $idSafety,
            'id_stok' => $stok->id_stok,
            'id_jenis' => $idJenis,
            'periode' => $periode,
            'safety_stok' => $safetyStok,
            'siap_salur' => $siapSalur,
        ]);

        return redirect()
            ->route('safety-stok.index')
            ->with('success', 'Safety stok berhasil dihitung.');
    }

    public function destroy($id)
    {
        try {

            $safety = SafetyStok::findOrFail($id);

            $safety->delete();

            return redirect()
                ->route('safety-stok.index')
                ->with('success', 'Data safety stok berhasil dihapus.');

        } catch (QueryException $e) {

            return redirect()
                ->route('safety-stok.index')
                ->with('error', 'Data safety stok tidak dapat dihapus karena masih digunakan pada data penyaluran.');

        }
    }
}