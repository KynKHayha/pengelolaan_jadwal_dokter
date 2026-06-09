<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Models\User;

// Explicit route model binding for {pengguna} => User model
Route::bind('pengguna', function ($value) {
    return User::findOrFail($value);
});

// Halaman Welcome
Route::get('/', function () {
    return view('welcome');
});

// ============================================================
// RUTE PENGGUNA BIASA (AUTH)
// ============================================================
Route::middleware('auth')->group(function () {

    // Redirect /dashboard sesuai role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk pengguna biasa (non-admin)
    Route::middleware('non.admin')->prefix('user')->name('user.')->group(function () {

        // Dashboard User
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        // Cari Jadwal
        Route::get('/cari-jadwal', [UserBookingController::class, 'cariJadwal'])->name('cari-jadwal');

        // Booking
        Route::get('/booking/create/{jadwal}', [UserBookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [UserBookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{booking}/konfirmasi', [UserBookingController::class, 'konfirmasi'])->name('booking.konfirmasi');
        Route::post('/booking/{booking}/upload-bukti', [UserBookingController::class, 'uploadBukti'])->name('booking.upload-bukti');
        Route::get('/booking/riwayat', [UserBookingController::class, 'riwayat'])->name('booking.riwayat');
        Route::post('/booking/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('booking.cancel');

        // Notifikasi user
        Route::get('/notifikasi', [UserBookingController::class, 'notifikasi'])->name('notifikasi.index');
    });
});

// ============================================================
// RUTE ADMIN (AUTH + ADMIN MIDDLEWARE)
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // CRUD Dokter
    Route::resource('dokter', DokterController::class);

    // CRUD Ruangan
    Route::resource('ruangan', RuanganController::class);

    // CRUD Jadwal
    Route::resource('jadwal', JadwalController::class);

    // Kelola Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [AdminBookingController::class, 'show'])->name('booking.show');
    Route::patch('/booking/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('booking.update-status');
    Route::delete('/booking/{booking}', [AdminBookingController::class, 'destroy'])->name('booking.destroy');

    // Verifikasi Pembayaran
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
    Route::patch('/pembayaran/{pembayaran}/verify', [AdminPembayaranController::class, 'verify'])->name('pembayaran.verify');

    // Data Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/{pengguna}', [PenggunaController::class, 'show'])->name('pengguna.show');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Notifikasi admin
    Route::get('/notifikasi', [\App\Http\Controllers\Admin\NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\Admin\NotifikasiController::class, 'readAll'])->name('notifikasi.read-all');
});

require __DIR__.'/auth.php';