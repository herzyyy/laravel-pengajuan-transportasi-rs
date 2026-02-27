<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransportRequestController;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    // Jika sudah login, langsung arahkan ke dashboard
    return redirect()->route('dashboard');
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'create'])
    ->name('login');
Route::post('/login', [AuthController::class, 'store'])
    ->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout');

// Aplikasi Pengajuan Transportasi (harus login)
Route::middleware('auth')->group(function () {
    // Setelah login, langsung masuk halaman pilih jenis transport
    Route::get('/dashboard', [TransportRequestController::class, 'choose'])
        ->name('dashboard');

    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [TransportRequestController::class, 'choose'])
            ->name('choose');

        // Umum
        Route::get('/umum', [TransportRequestController::class, 'createUmum'])
            ->name('umum.create');
        Route::post('/umum', [TransportRequestController::class, 'storeUmum'])
            ->name('umum.store');

        // API: check availability for mobil umum
        Route::get('/umum/check-availability', [TransportRequestController::class, 'checkAvailability'])
            ->name('umum.check');

        // Ambulance - langsung ke satu form, pilihan antar/jemput ada di form
        Route::get('/ambulance', [TransportRequestController::class, 'createAmbulance'])
            ->name('ambulance.create');
        // API: check availability for ambulance unit
        Route::get('/ambulance/check-availability', [TransportRequestController::class, 'checkAmbulanceAvailability'])
            ->name('ambulance.check');
        Route::post('/ambulance', [TransportRequestController::class, 'storeAmbulance'])
            ->name('ambulance.store');

        Route::get('/sukses/{transportRequest}', [TransportRequestController::class, 'success'])
            ->name('success');
        Route::get('/riwayat', [TransportRequestController::class, 'index'])
            ->name('index');
    });
});
