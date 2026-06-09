<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $query = Booking::with(['user', 'jadwal.dokter', 'jadwal.ruangan', 'pembayaran'])
            ->latest();

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $bookings = $query->paginate(15);
        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'jadwal.dokter', 'jadwal.ruangan', 'pembayaran']);
        return view('admin.booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status'        => 'required|in:pending,confirmed,cancelled',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.booking.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.booking.index')
            ->with('success', 'Data booking berhasil dihapus!');
    }
}
