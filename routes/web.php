<?php

use Illuminate\Support\Facades\Route;

// =========================
// AUTH
// =========================
use App\Http\Controllers\Auth\LoginController;

// =========================
// DASHBOARD
// =========================
use App\Http\Controllers\DashboardController;

// =========================
// PROFILE
// =========================
use App\Http\Controllers\ProfileController;

// =========================
// MASTER DATA
// =========================
use App\Http\Controllers\KiosController;
use App\Http\Controllers\JenisPupukController;
use App\Http\Controllers\StokPupukController;
use App\Http\Controllers\PengajuanController;

// =========================
// PREDIKSI
// =========================
use App\Http\Controllers\HistorisPenyaluranController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\SafetyStokController;
use App\Http\Controllers\PenyaluranController;

// =========================
// LAPORAN
// =========================
use App\Http\Controllers\LaporanController;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');

});


/*
|--------------------------------------------------------------------------
| AUTH (Guest)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.authenticate');


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])
        ->name('forgot-password');

    Route::post('/forgot-password', [LoginController::class, 'sendOtp'])
        ->name('forgot-password.send');


    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    Route::get('/verify-otp', [LoginController::class, 'showVerifyOtp'])
        ->name('verify-otp');

    Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])
        ->name('verify-otp.verify');


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get('/reset-password', [LoginController::class, 'showResetPassword'])
        ->name('reset-password');

    Route::post('/reset-password', [LoginController::class, 'resetPassword'])
        ->name('reset-password.update');

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN & PEMILIK
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,pemilik'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::post('/laporan', [LaporanController::class, 'tampilkan'])
        ->name('laporan.tampilkan');

    Route::get('/laporan/print', [LaporanController::class, 'print'])
        ->name('laporan.print');

    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])
        ->name('laporan.pdf');

    Route::get('/laporan/excel', [LaporanController::class, 'excel'])
        ->name('laporan.excel');

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    |--------------------------------------------------------------------------
    */

    Route::resource('kios', KiosController::class);

    Route::resource('jenis-pupuk', JenisPupukController::class);

    Route::resource('stok-pupuk', StokPupukController::class);

    Route::resource('pengajuan', PengajuanController::class);

    Route::resource('historis-penyaluran', HistorisPenyaluranController::class);


    /*
    |--------------------------------------------------------------------------
    | PREDIKSI
    |--------------------------------------------------------------------------
    */

    Route::get('/prediksi', [PrediksiController::class, 'index'])
        ->name('prediksi.index');

    Route::post('/prediksi/proses', [PrediksiController::class, 'proses'])
        ->name('prediksi.proses');

    Route::delete('/prediksi/{id}', [PrediksiController::class, 'destroy'])
        ->name('prediksi.destroy');


    /*
    |--------------------------------------------------------------------------
    | SAFETY STOK
    |--------------------------------------------------------------------------
    */

    Route::get('/safety-stok', [SafetyStokController::class, 'index'])
        ->name('safety-stok.index');

    Route::post('/safety-stok/proses', [SafetyStokController::class, 'proses'])
        ->name('safety-stok.proses');

    Route::delete('/safety-stok/{id}', [SafetyStokController::class, 'destroy'])
        ->name('safety-stok.destroy');


    /*
    |--------------------------------------------------------------------------
    | PENYALURAN
    |--------------------------------------------------------------------------
    */

    Route::get('/penyaluran', [PenyaluranController::class, 'index'])
        ->name('penyaluran.index');

    Route::post('/penyaluran/hitung', [PenyaluranController::class, 'hitung'])
        ->name('penyaluran.hitung');

    Route::get('/penyaluran/{id}/edit', [PenyaluranController::class, 'edit'])
        ->name('penyaluran.edit');

    Route::put('/penyaluran/{id}', [PenyaluranController::class, 'update'])
        ->name('penyaluran.update');

    Route::delete('/penyaluran', [PenyaluranController::class, 'destroyAll'])
    ->name('penyaluran.destroyAll');

});