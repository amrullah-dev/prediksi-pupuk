<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokPupuk;
use App\Models\JenisPupuk;
use Illuminate\Database\QueryException;

class StokPupukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokPupuk = StokPupuk::with('jenisPupuk')
            ->orderByDesc('periode')
            ->get();

        return view('stok-pupuk.index', compact('stokPupuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('stok-pupuk.create', compact('jenisPupuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id_jenis' => 'required|exists:jenis_pupuk,id_jenis',
                'periode' => 'required|date',
                'jumlah_stok' => 'required|numeric|min:0',
            ],
            [
                'id_jenis.required' => 'Jenis pupuk wajib dipilih.',
                'id_jenis.exists' => 'Jenis pupuk yang dipilih tidak valid.',

                'periode.required' => 'Periode wajib diisi.',
                'periode.date' => 'Format periode tidak valid.',

                'jumlah_stok.required' => 'Jumlah stok wajib diisi.',
                'jumlah_stok.numeric' => 'Jumlah stok harus berupa angka.',
                'jumlah_stok.min' => 'Jumlah stok tidak boleh kurang dari 0.',
            ]
        );

        $periode = $request->periode . '-01';
        $sudahAda = StokPupuk::where('id_jenis', $request->id_jenis)
            ->where('periode', $periode)
            ->exists();

        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'periode' => 'Data stok untuk jenis pupuk pada periode tersebut sudah tersedia.'
                ]);

        }

        $stokTerakhir = StokPupuk::orderBy('id_stok', 'desc')->first();

        if ($stokTerakhir) {
            $nomor = (int) substr($stokTerakhir->id_stok, 3) + 1;
        } else {
            $nomor = 1;
        }

        $idStok = 'STK' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        StokPupuk::create([
            'id_stok' => $idStok,
            'id_jenis' => $request->id_jenis,
            'periode' => $periode,
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        return redirect()->route('stok-pupuk.index')
            ->with('success', 'Data stok pupuk berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        $stokPupuk = StokPupuk::findOrFail($id);

        $jenisPupuk = JenisPupuk::orderBy('nama_pupuk')->get();

        return view('stok-pupuk.edit', compact(
            'stokPupuk',
            'jenisPupuk'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'id_jenis' => 'required|exists:jenis_pupuk,id_jenis',
                'periode' => 'required|date',
                'jumlah_stok' => 'required|numeric|min:0',
            ],
            [
                'id_jenis.required' => 'Jenis pupuk wajib dipilih.',
                'id_jenis.exists' => 'Jenis pupuk yang dipilih tidak valid.',

                'periode.required' => 'Periode wajib diisi.',
                'periode.date' => 'Format periode tidak valid.',

                'jumlah_stok.required' => 'Jumlah stok wajib diisi.',
                'jumlah_stok.numeric' => 'Jumlah stok harus berupa angka.',
                'jumlah_stok.min' => 'Jumlah stok tidak boleh kurang dari 0.',
            ]
        );

        $periode = $request->periode . '-01';

        // Cek apakah sudah ada data lain
        // dengan jenis pupuk dan periode yang sama.
        $sudahAda = StokPupuk::where('id_jenis', $request->id_jenis)
            ->where('periode', $periode)
            ->where('id_stok', '!=', $id)
            ->exists();

        if ($sudahAda) {

            return back()
                ->withInput()
                ->withErrors([
                    'periode' => 'Data stok untuk jenis pupuk pada periode tersebut sudah tersedia.'
                ]);

        }

        // Ambil data yang sedang diedit.
        $stokPupuk = StokPupuk::findOrFail($id);

        // Update data.
        $stokPupuk->update([
            'id_jenis' => $request->id_jenis,
            'periode' => $periode,
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        return redirect()
            ->route('stok-pupuk.index')
            ->with('success', 'Data stok pupuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stok = StokPupuk::findOrFail($id);

        if ($stok->safetyStok()->exists()) {

            return redirect()
                ->route('stok-pupuk.index')
                ->with('error', 'Data stok pupuk tidak dapat dihapus karena masih digunakan pada data safety stok.');
        }

        $stok->delete();

        return redirect()
            ->route('stok-pupuk.index')
            ->with('success', 'Data stok pupuk berhasil dihapus.');
    }
}
