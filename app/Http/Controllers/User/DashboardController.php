<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalBooking       = $user->bookings()->count();
        $bookingMenunggu    = $user->bookings()->where('status', 'pending')->count();
        $bookingDikonfirmasi = $user->bookings()->where('status', 'confirmed')->count();

        $recentBookings = $user->bookings()
            ->with(['jadwal.dokter', 'jadwal.ruangan', 'pembayaran'])
            ->latest()
            ->take(3)
            ->get();

        $jadwalTersedia = Jadwal::with(['dokter', 'ruangan', 'bookings'])
            ->where('is_active', true)
            ->take(6)
            ->get();

        return view('user.dashboard', compact(
            'totalBooking', 'bookingMenunggu', 'bookingDikonfirmasi',
            'recentBookings', 'jadwalTersedia'
        ));
    }
}
