<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman Forgot Password
     */
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Mengirim OTP
     */
    public function sendOtp(Request $request)
    {

        // ==========================
        // VALIDASI
        // ==========================

        $request->validate([

            'email' => 'required|email',

        ], [

            'email.required' => 'Email wajib diisi.',

            'email.email' => 'Format email tidak valid.',

        ]);

        // ==========================
        // CEK EMAIL
        // ==========================

        $user = User::where('email', $request->email)->first();

        if (!$user) {

            return back()

                ->withInput()

                ->with('error', 'Email tidak terdaftar.');

        }

        // ==========================
        // HAPUS OTP LAMA
        // ==========================

        PasswordResetOtp::where('email', $request->email)->delete();

        // ==========================
        // GENERATE OTP
        // ==========================

        $otp = random_int(100000, 999999);

        // ==========================
        // SIMPAN OTP
        // ==========================

        PasswordResetOtp::create([

            'email' => $request->email,

            'otp' => $otp,

            'expired_at' => now()->addMinutes(5),

        ]);

        PasswordResetOtp::create([

            'email' => $request->email,

            'otp' => $otp,

            'expired_at' => now()->addMinutes(5),

        ]);

        // ==========================
        // KIRIM EMAIL
        // ==========================

        Mail::to($request->email)
            ->send(new OtpMail($otp));

        // ==========================
        // REDIRECT
        // ==========================

        return redirect()
            ->route('verify-otp')
            ->with('success', 'Kode OTP berhasil dikirim ke email Anda.')
            ->with('email', $request->email);

    }

    /**
     * Menampilkan halaman Verifikasi OTP
     */
    public function showVerifyOtp()
    {
        return view('auth.verify-otp');
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        // ==========================
        // VALIDASI
        // ==========================

        $request->validate([
            'otp' => 'required'
        ], [
            'otp.required' => 'Kode OTP wajib diisi.'
        ]);

        // ==========================
        // CARI OTP
        // ==========================

        $otp = PasswordResetOtp::where('otp', $request->otp)->first();

        if (!$otp) {

            return back()
                ->with('error', 'Kode OTP tidak valid.');

        }

        // ==========================
        // CEK MASA BERLAKU OTP
        // ==========================

        if ($otp->expired_at->isPast()) {

            return back()
                ->with('error', 'Kode OTP telah kedaluwarsa.');

        }

        // ==========================
        // SIMPAN EMAIL KE SESSION
        // ==========================

        session([
            'password_reset_verified' => true,
            'reset_email' => $otp->email
        ]);

        // ==========================
        // HAPUS OTP
        // ==========================

        $otp->delete();

        // ==========================
        // REDIRECT
        // ==========================

        return redirect()
            ->route('reset-password')
            ->with('success', 'OTP berhasil diverifikasi. Silakan buat password baru.');
    }

    /**
     * Menampilkan halaman Reset Password
     */
    public function showResetPassword()
    {
        // ==========================
        // CEK SESSION RESET PASSWORD
        // ==========================

        if (
            !session()->has('password_reset_verified') ||
            !session()->has('reset_email')
        ) {

            return redirect()
                ->route('forgot-password')
                ->with('error', 'Silakan lakukan verifikasi OTP terlebih dahulu.');

        }

        return view('auth.reset-password');
    }
    

    /**
     * Menyimpan password baru
     */
    public function resetPassword(Request $request)
    {
        // ==========================
        // VALIDASI
        // ==========================

        $request->validate([

            'password' => 'required|min:8|confirmed',

        ], [

            'password.required' => 'Password baru wajib diisi.',

            'password.min' => 'Password minimal 8 karakter.',

            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

        ]);

        // ==========================
        // AMBIL EMAIL DARI SESSION
        // ==========================

        $email = session('reset_email');

        // ==========================
        // CEK SESSION
        // ==========================

        if (!$email) {

            return redirect()
                ->route('forgot-password')
                ->with('error', 'Sesi reset password telah berakhir.');

        }

        // ==========================
        // CARI USER
        // ==========================

        $user = User::where('email', $email)->first();

        if (!$user) {

            return redirect()
                ->route('forgot-password')
                ->with('error', 'User tidak ditemukan.');

        }

        // ==========================
        // UPDATE PASSWORD
        // ==========================

        $user->password = bcrypt($request->password);

        $user->save();

        // ==========================
        // HAPUS SESSION RESET PASSWORD
        // ==========================

        session()->forget('password_reset_verified');

        session()->forget('reset_email');

        // ==========================
        // REDIRECT LOGIN
        // ==========================

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login menggunakan password baru.');
    }

    /**
     * Proses Login
     */
    public function authenticate(Request $request)
    {
        // ==========================
        // VALIDASI INPUT
        // ==========================

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // ==========================
        // LOGIN
        // ==========================

        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 'admin') {

                return redirect()->route('dashboard');

            }

            if ($user->role == 'pemilik') {

                return redirect()->route('dashboard');

            }

            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'Role pengguna tidak dikenali.');

        }

        // ==========================
        // LOGIN GAGAL
        // ==========================

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau Password yang Anda masukkan salah.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    
}