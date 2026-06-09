<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Jadwal;
use App\Models\Pembayaran;
use App\Models\User;
use App\Notifications\PembayaranDiajukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Tampilkan form untuk memilih jadwal dokter.
     */
    public function cariJadwal(Request $request)
    {
        $query = Jadwal::with(['dokter', 'ruangan', 'bookings'])
            ->where('is_active', true);

        if ($request->filled('spesialisasi')) {
            $query->whereHas('dokter', fn($q) => $q->where('spesialisasi', 'like', '%' . $request->spesialisasi . '%'));
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $jadwals = $query->get();
        $spesialisasis = \App\Models\Dokter::select('spesialisasi')->distinct()->pluck('spesialisasi');

        return view('user.cari-jadwal', compact('jadwals', 'spesialisasis'));
    }

    /**
     * Tampilkan form booking untuk jadwal tertentu.
     */
    public function create(Jadwal $jadwal)
    {
        $jadwal->load(['dokter', 'ruangan', 'bookings']);
        return view('user.booking.create', compact('jadwal'));
    }

    /**
     * Simpan booking baru dengan validasi hari tanggal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id'       => 'required|exists:jadwals,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan'         => 'nullable|string|max:500',
        ]);

        // Validasi: tanggal harus sesuai hari praktik jadwal
        $jadwal = Jadwal::findOrFail($validated['jadwal_id']);
        $hariMap = [
            'Senin'  => Carbon::MONDAY,
            'Selasa' => Carbon::TUESDAY,
            'Rabu'   => Carbon::WEDNESDAY,
            'Kamis'  => Carbon::THURSDAY,
            'Jumat'  => Carbon::FRIDAY,
            'Sabtu'  => Carbon::SATURDAY,
            'Minggu' => Carbon::SUNDAY,
        ];
        $tanggal = Carbon::parse($validated['tanggal_booking']);
        if (isset($hariMap[$jadwal->hari]) && $tanggal->dayOfWeek !== $hariMap[$jadwal->hari]) {
            return back()->withErrors([
                'tanggal_booking' => 'Tanggal booking harus hari ' . $jadwal->hari . '. Tanggal yang dipilih adalah ' . $tanggal->locale('id')->isoFormat('dddd') . '.',
            ])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        $booking = Booking::create($validated);

        return redirect()->route('user.booking.konfirmasi', $booking)
            ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Tampilkan halaman konfirmasi booking & form pembayaran.
     */
    public function konfirmasi(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        $booking->load(['jadwal.dokter', 'jadwal.ruangan', 'pembayaran']);
        return view('user.booking.konfirmasi', compact('booking'));
    }

    /**
     * Upload bukti pembayaran — field names sesuai DB model.
     */
    public function uploadBukti(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status === 'cancelled', 403, 'Booking yang dibatalkan tidak dapat dibayar.');

        $request->validate([
            'bukti_transfer'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jumlah'            => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:100',
        ]);

        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        Pembayaran::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'jumlah'            => $request->jumlah,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_transfer'    => $path,
                'status_pembayaran' => 'pending',
            ]
        );

        // Kirim notifikasi ke semua admin
        $admins = User::where('role', 'admin')->get();
        $booking->load('user');
        foreach ($admins as $admin) {
            $admin->notify(new PembayaranDiajukan($booking));
        }

        return redirect()->route('user.booking.konfirmasi', $booking)
            ->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    /**
     * Tampilkan riwayat booking user.
     */
    public function riwayat(Request $request)
    {
        $query = Auth::user()->bookings()
            ->with(['jadwal.dokter', 'jadwal.ruangan', 'pembayaran'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);
        return view('user.booking.riwayat', compact('bookings'));
    }

    /**
     * Batalkan booking.
     */
    public function cancel(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if($booking->status === 'confirmed', 403, 'Booking yang sudah dikonfirmasi tidak dapat dibatalkan.');

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('user.booking.riwayat')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Tampilkan semua notifikasi user.
     */
    public function notifikasi()
    {
        $notifications = Auth::user()->notifications()->paginate(15);
        Auth::user()->unreadNotifications->markAsRead();
        return view('user.notifikasi', compact('notifications'));
    }
}
