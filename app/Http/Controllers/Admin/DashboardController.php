<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDokter   = Dokter::count();
        $totalJadwal   = Jadwal::where('is_active', true)->count();
        $totalBooking  = Booking::count();
        $bookingPending = Booking::where('status', 'pending')->count();
        $totalPengguna = User::where('role', 'user')->count();
        $recentBookings = Booking::with(['user', 'jadwal.dokter'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalDokter', 'totalJadwal', 'totalBooking',
            'bookingPending', 'totalPengguna', 'recentBookings'
        ));
    }
}
