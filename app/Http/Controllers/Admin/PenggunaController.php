<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = User::where('role', 'user')
            ->withCount('bookings')
            ->latest()
            ->paginate(15);
        return view('admin.pengguna.index', compact('penggunas'));
    }

    public function show(User $pengguna)
    {
        $pengguna->load(['bookings.jadwal.dokter', 'bookings.jadwal.ruangan', 'bookings.pembayaran']);
        return view('admin.pengguna.show', compact('pengguna'));
    }
}
