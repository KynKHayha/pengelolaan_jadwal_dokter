@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan sistem DocPlanner hari ini')

@section('content')
<div class="space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-800">{{ $totalDokter }}</p>
                <p class="text-sm text-slate-500 font-medium">Total Dokter</p>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-800">{{ $totalJadwal }}</p>
                <p class="text-sm text-slate-500 font-medium">Jadwal Aktif</p>
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-800">{{ $totalBooking }}</p>
                <p class="text-sm text-slate-500 font-medium">Total Booking</p>
                @if($bookingPending > 0)
                    <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-medium">{{ $bookingPending }} pending</span>
                @endif
            </div>
        </div>

        <div class="stat-card bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-800">{{ $totalPengguna }}</p>
                <p class="text-sm text-slate-500 font-medium">Pengguna Terdaftar</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions + Recent Bookings -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Aksi Cepat</h3>
            <div class="space-y-2.5">
                <a href="{{ route('admin.dokter.create') }}" class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all group">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-blue-700">Tambah Dokter</span>
                </a>
                <a href="{{ route('admin.jadwal.create') }}" class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-all group">
                    <div class="w-9 h-9 bg-green-600 rounded-lg flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-green-700">Tambah Jadwal</span>
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-3 p-3 bg-amber-50 hover:bg-amber-100 rounded-xl transition-all group">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-amber-700">Verifikasi Pembayaran</span>
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 rounded-xl transition-all group">
                    <div class="w-9 h-9 bg-slate-600 rounded-lg flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">Cetak Laporan</span>
                </a>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Booking Terbaru</h3>
                <a href="{{ route('admin.booking.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua â†’</a>
            </div>
            @if($recentBookings->isEmpty())
                <div class="py-12 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm">Belum ada booking</p>
                </div>
            @else
                <div class="divide-y divide-slate-50">
                    @foreach($recentBookings as $booking)
                    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50 transition-colors">
                        <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-sm font-bold flex-shrink-0">
                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $booking->user->name }}</p>
                            <p class="text-xs text-slate-500">Dr. {{ $booking->jadwal->dokter->nama_dokter }} &bull; {{ $booking->jadwal->hari }}</p>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold flex-shrink-0 {{ $booking->getStatusBadgeClass() }}">
                            {{ $booking->getStatusLabel() }}
                        </span>
                        <a href="{{ route('admin.booking.show', $booking) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
