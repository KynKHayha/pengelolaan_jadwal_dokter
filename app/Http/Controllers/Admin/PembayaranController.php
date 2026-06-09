<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Notifications\PembayaranDiverifikasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $query = Pembayaran::with(['booking.user', 'booking.jadwal.dokter'])->latest();

        if (request()->filled('status')) {
            $query->where('status_pembayaran', request('status'));
        }

        $pembayarans = $query->paginate(15);
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['booking.user', 'booking.jadwal.dokter', 'booking.jadwal.ruangan']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verify(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:valid,invalid',
            'catatan'           => 'nullable|string|max:500',
        ]);

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran,
            'catatan'           => $request->catatan,
        ]);

        // Update booking status berdasarkan verifikasi
        if ($request->status_pembayaran === 'valid') {
            $pembayaran->booking->update(['status' => 'confirmed']);
        } elseif ($request->status_pembayaran === 'invalid') {
            $pembayaran->booking->update(['status' => 'cancelled']);
        }

        // Kirim notifikasi ke user
        $pembayaran->load('booking.user');
        $pembayaran->booking->user->notify(new PembayaranDiverifikasi($pembayaran));

        $msg = $request->status_pembayaran === 'valid'
            ? 'Pembayaran berhasil diverifikasi! Booking dikonfirmasi.'
            : 'Pembayaran ditolak. Booking dibatalkan.';

        return redirect()->route('admin.pembayaran.show', $pembayaran)
            ->with('success', $msg);
    }
}
