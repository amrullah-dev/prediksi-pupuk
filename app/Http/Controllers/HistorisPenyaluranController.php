<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\HistorisPenyaluran;
use App\Models\Kios;
use App\Models\Prediksi;
use App\Models\JenisPupuk;



class HistorisPenyaluranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historis = HistorisPenyaluran::with([
            'kios',
            'jenisPupuk'
        ])
            ->orderBy('periode')
            ->get();

        return view('historis-penyaluran.index', compact('historis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kios = Kios::orderBy('nama_kios')->get();
        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view(
            'historis-penyaluran.create',
            compact(
                'kios',
                'jenisPupuk'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kios'=>'required|exists:kios,id_kios',
            'id_jenis'=>'required|exists:jenis_pupuk,id_jenis',
            'periode'=>'required|date',
            'jumlah_penyaluran'=>'required|numeric|min:0',
        ]);

        $periode = $request->periode . '-01';

        // Cek apakah data historis sudah ada
        $cek = HistorisPenyaluran::where('id_kios',$request->id_kios)
            ->where('id_jenis',$request->id_jenis)
            ->where('periode',$periode)
            ->exists();

        if ($cek) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data historis untuk kios dan periode tersebut sudah tersedia.');
        }

        $historisTerakhir = HistorisPenyaluran::orderBy('id_historis', 'desc')->first();

        if ($historisTerakhir) {
            $nomor = (int) substr($historisTerakhir->id_historis, 3) + 1;
        } else {
            $nomor = 1;
        }

        $idHistoris = 'HST' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        HistorisPenyaluran::create([
            'id_historis' => $idHistoris,
            'id_kios' => $request->id_kios,
            'id_jenis'=>$request->id_jenis,
            'periode' => $periode,
            'jumlah_penyaluran' => $request->jumlah_penyaluran,
        ]);

        return redirect()
            ->route('historis-penyaluran.index')
            ->with('success', 'Data historis berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $historis = HistorisPenyaluran::findOrFail($id);

        $kios = Kios::orderBy('nama_kios')->get();
        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view(
            'historis-penyaluran.edit',
            compact(
                'historis',
                'kios',
                'jenisPupuk'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kios' => 'required|exists:kios,id_kios',
            'id_jenis'=>'required|exists:jenis_pupuk,id_jenis',
            'periode' => 'required|date',
            'jumlah_penyaluran' => 'required|numeric|min:0',
        ]);

        $historis = HistorisPenyaluran::findOrFail($id);

        $periode = $request->periode . '-01';

        // Cek apakah sudah ada data lain dengan kios & periode yang sama
        $cek = HistorisPenyaluran::where('id_kios',$request->id_kios)
            ->where('id_jenis',$request->id_jenis)
            ->where('periode',$periode)
            ->where('id_historis','!=',$historis->id_historis)
            ->exists();

        if ($cek) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Data historis untuk kios dan periode tersebut sudah tersedia.');
        }

        $historis->update([
            'id_kios' => $request->id_kios,
            'id_jenis'=>$request->id_jenis,
            'periode' => $periode,
            'jumlah_penyaluran' => $request->jumlah_penyaluran,
        ]);

        return redirect()
            ->route('historis-penyaluran.index')
            ->with('success', 'Data historis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Ambil data historis yang akan dihapus
        $historis = HistorisPenyaluran::findOrFail($id);

        // Cek apakah historis ini menjadi bagian dari
        // data yang digunakan dalam proses prediksi.
        $digunakanPrediksi = Prediksi::where('id_kios', $historis->id_kios)
            ->where('id_jenis', $historis->id_jenis)
            ->where('periode', '>', $historis->periode)
            ->exists();

        if ($digunakanPrediksi) {

            return redirect()
                ->route('historis-penyaluran.index')
                ->with(
                    'error',
                    'Data historis tidak dapat dihapus karena sudah digunakan pada proses prediksi.'
                );
        }

        // Jika tidak digunakan pada prediksi, data dapat dihapus
        $historis->delete();

        return redirect()
            ->route('historis-penyaluran.index')
            ->with(
                'success',
                'Data historis berhasil dihapus.'
            );
    }
}