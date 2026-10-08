<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPupuk;

class JenisPupukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisPupuk = JenisPupuk::all();

        return view('jenis-pupuk.index', compact('jenisPupuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-pupuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pupuk' => 'required|max:100',
        ]);

        $jenisTerakhir = JenisPupuk::orderBy('id_jenis', 'desc')->first();

        if ($jenisTerakhir) {
            $nomor = (int) substr($jenisTerakhir->id_jenis, 3) + 1;
        } else {
            $nomor = 1;
        }

        $idJenis = 'JNS' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        JenisPupuk::create([
            'id_jenis'    => $idJenis,
            'nama_pupuk'  => $request->nama_pupuk,
        ]);

        return redirect()
            ->route('jenis-pupuk.index')
            ->with('success', 'Data jenis pupuk berhasil ditambahkan.');
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
        $jenisPupuk = JenisPupuk::findOrFail($id);

        return view('jenis-pupuk.edit', compact('jenisPupuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pupuk' => 'required|max:100',
        ]);

        $jenisPupuk = JenisPupuk::findOrFail($id);

        $jenisPupuk->update([
            'nama_pupuk' => $request->nama_pupuk,
        ]);

        return redirect()
            ->route('jenis-pupuk.index')
            ->with('success', 'Data jenis pupuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisPupuk = JenisPupuk::findOrFail($id);

        $jenisPupuk->delete();

        return redirect()
            ->route('jenis-pupuk.index')
            ->with('success', 'Data jenis pupuk berhasil dihapus.');
    }
}