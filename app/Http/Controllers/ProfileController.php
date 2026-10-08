<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman Profile
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Menampilkan halaman Edit Profile
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Menyimpan perubahan Profile
     */
    public function update(Request $request)
    {
        // ==========================
        // VALIDASI
        // ==========================

        $request->validate([

            'nama' => 'required|max:100',

            'email' => 'required|email|unique:users,email,' . auth()->id(),

            'password' => 'nullable|min:8|confirmed',

        ], [

            'nama.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',

            'email.email' => 'Format email tidak valid.',

            'email.unique' => 'Email sudah digunakan.',

            'password.min' => 'Password minimal 8 karakter.',

            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

        ]);

        // ==========================
        // USER LOGIN
        // ==========================

        $user = auth()->user();

        // ==========================
        // UPDATE DATA
        // ==========================

        $user->nama = $request->nama;

        $user->email = $request->email;

        // ==========================
        // PASSWORD (OPSIONAL)
        // ==========================

        if (!empty($request->password)) {

            $user->password = bcrypt($request->password);

        }

        // ==========================
        // SIMPAN
        // ==========================

        $user->save();

        // ==========================
        // REDIRECT
        // ==========================

        return redirect()
            ->route('profile')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}