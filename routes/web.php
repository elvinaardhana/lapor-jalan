<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


// =====================================================
// HALAMAN PUBLIK
// =====================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/peta', [HomeController::class, 'peta'])
    ->name('peta');

Route::get('/laporan-publik', [HomeController::class, 'laporanPublik'])
    ->name('laporan.publik');

Route::get('/akun', [HomeController::class, 'akun'])
    ->name('akun');


// =====================================================
// AUTENTIKASI
// =====================================================

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);


// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);


// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');


// =====================================================
// ROUTE MASYARAKAT — HARUS LOGIN
// =====================================================

Route::middleware('auth')->group(function () {

    Route::resource('laporan', LaporanController::class);

    Route::get('/laporan-saya', [LaporanController::class, 'riwayat'])
        ->name('laporan.saya');

    Route::get('/laporan/{id}', [LaporanController::class, 'show'])
        ->name('laporan.show');

});


// =====================================================
// FORM LAPORAN / VALIDASI LOKASI
// =====================================================

Route::get('/geojson/wonogiri', [LaporanController::class, 'geojsonWonogiri'])
    ->name('geojson.wonogiri');

Route::post('/cek-wonogiri', [LaporanController::class, 'cekWonogiri'])
    ->name('cek.wonogiri');


// =====================================================
// ROUTE KHUSUS ADMIN
// =====================================================

Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');


    // Data Laporan
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])
        ->name('admin.laporan');

    // download Data
    Route::get(
        '/admin/laporan/download', [AdminController::class, 'downloadLaporan'])
        ->name('admin.laporan.download');
    
    // Detail Laporan
    Route::get('/admin/laporan/{id}', [AdminController::class, 'detail'])
        ->name('admin.laporan.detail');


    // Hapus Laporan
    Route::delete('/admin/laporan/{id}', [AdminController::class, 'destroy'])
        ->name('admin.laporan.destroy');


    // Status Diproses
    Route::patch('/admin/laporan/{id}/diproses',
        [AdminController::class, 'diproses'])
        ->name('admin.laporan.diproses');


    // Status Diteruskan
    Route::patch('/admin/laporan/{id}/diteruskan',
        [AdminController::class, 'diteruskan'])
        ->name('admin.laporan.diteruskan');


    // Status Ditolak
    Route::patch('/admin/laporan/{id}/ditolak',
        [AdminController::class, 'ditolak'])
        ->name('admin.laporan.ditolak');


    // Update Status
    Route::patch('/admin/laporan/{id}/status',
        [AdminController::class, 'updateStatus'])
        ->name('admin.laporan.updateStatus');


    // Peta Prioritas
    Route::get('/admin/peta-prioritas',
        [AdminController::class, 'petaPrioritas'])
        ->name('admin.petaPrioritas');

});

// notifikasi
    Route::post('/push-subscription', function (\Illuminate\Http\Request $request) {
    
        $request->validate([
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);
    
        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->input('keys.p256dh'),
            $request->input('keys.auth'),
            $request->input('content_encoding', 'aes128gcm')
        );
    
        return response()->json([
            'success' => true
        ]);
    
    })->middleware('auth')->name('push.subscribe');
    Route::delete('/push-subscription', function (\Illuminate\Http\Request $request) {
    
        $request->validate([
            'endpoint' => 'required|string',
        ]);
    
        $request->user()
            ->pushSubscriptions()
            ->where('endpoint', $request->endpoint)
            ->delete();
    
        return response()->json([
            'success' => true
        ]);
    
    })->middleware('auth')->name('push.unsubscribe');

