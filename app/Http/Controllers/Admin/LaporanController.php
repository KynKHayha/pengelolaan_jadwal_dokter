<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'jadwal.dokter', 'jadwal.ruangan', 'pembayaran'])
            ->latest()
            ->get();

        $totalPendapatan = Pembayaran::where('status_pembayaran', 'valid')->sum('jumlah');
        $totalBookingConfirmed = Booking::where('status', 'confirmed')->count();
        $totalBookingCancelled = Booking::where('status', 'cancelled')->count();

        return view('admin.laporan.index', compact(
            'bookings', 'totalPendapatan',
            'totalBookingConfirmed', 'totalBookingCancelled'
        ));
    }
}
