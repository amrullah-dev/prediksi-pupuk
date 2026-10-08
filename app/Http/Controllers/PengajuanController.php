<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Kios;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuan = Pengajuan::with('kios')->get();

        return view('pengajuan.index', compact('pengajuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kios = Kios::orderBy('nama_kios')->get();

        return view('pengajuan.create', compact('kios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kios' => 'required|exists:kios,id_kios',
            'periode' => 'required|date',
            'jumlah_pengajuan' => 'required|numeric|min:0',
        ]);

        $periode = $request->periode . '-01';

        $pengajuanTerakhir = Pengajuan::orderBy('id_pengajuan', 'desc')->first();

        if ($pengajuanTerakhir) {
            $nomor = (int) substr($pengajuanTerakhir->id_pengajuan, 3) + 1;
        } else {
            $nomor = 1;
        }

        $idPengajuan = 'PGJ' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

        Pengajuan::create([
            'id_pengajuan' => $idPengajuan,
            'id_kios' => $request->id_kios,
            'periode' => $periode,
            'jumlah_pengajuan' => $request->jumlah_pengajuan,
        ]);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Data pengajuan berhasil ditambahkan.');
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
        $pengajuan = Pengajuan::findOrFail($id);
        $kios = Kios::orderBy('nama_kios')->get();

        return view('pengajuan.edit', compact('pengajuan', 'kios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kios' => 'required|exists:kios,id_kios',
            'periode' => 'required|date',
            'jumlah_pengajuan' => 'required|numeric|min:0',
        ]);

        $periode = $request->periode . '-01';

        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->update([
            'id_kios' => $request->id_kios,
            'periode' => $periode,
            'jumlah_pengajuan' => $request->jumlah_pengajuan,
        ]);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Data pengajuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')
            ->with('success', 'Data pengajuan berhasil dihapus.');
    }
}
