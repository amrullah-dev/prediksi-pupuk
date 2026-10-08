<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kios;
use Illuminate\Database\QueryException;

class KiosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kios = Kios::all();

        return view('kios.index', compact('kios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kios' => 'required|max:100',
            'kecamatan' => 'required|max:100',
        ]);

        $kiosTerakhir = Kios::orderBy('id_kios', 'desc')->first();

        if ($kiosTerakhir) {
            $nomor = (int) substr($kiosTerakhir->id_kios, 3) + 1;
        } else {
            $nomor = 1;
        }

        $idKios = 'KRS' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        Kios::create([
            'id_kios' => $idKios,
            'nama_kios' => $request->nama_kios,
            'kecamatan' => $request->kecamatan,
        ]);

        return redirect()->route('kios.index')
                        ->with('success', 'Data kios berhasil ditambahkan.');
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
        $kios = Kios::findOrFail($id);

        return view('kios.edit', compact('kios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kios' => 'required|max:100',
            'kecamatan' => 'required|max:100',
        ]);

        $kios = Kios::findOrFail($id);

        $kios->update([
            'nama_kios' => $request->nama_kios,
            'kecamatan' => $request->kecamatan,
        ]);

        return redirect()->route('kios.index')
            ->with('success', 'Data kios berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kios = Kios::findOrFail($id);

        if (
            $kios->historisPenyaluran()->exists() ||
            $kios->prediksi()->exists() ||
            $kios->penyaluran()->exists()
        ) {
            return redirect()
                ->route('kios.index')
                ->with('error', 'Data kios tidak dapat dihapus karena masih digunakan pada data historis penyaluran, prediksi, atau penyaluran.');
        }

        $kios->delete();

        return redirect()
            ->route('kios.index')
            ->with('success', 'Data kios berhasil dihapus.');
    }
}
