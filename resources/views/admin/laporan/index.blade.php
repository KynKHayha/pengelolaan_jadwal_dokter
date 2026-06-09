@extends('layouts.admin')
@section('page-title', 'Laporan Sistem')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Laporan Sistem</h1>
            <p class="text-sm text-slate-500 mt-1">Ringkasan data dan laporan lengkap sistem</p>
        </div>
        <button onclick="window.print()"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Laporan
        </button>
    </div>

    {{-- Print Header (visible only when printing) --}}
    <div class="hidden print:block mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Laporan Sistem</h1>
        <p class="text-slate-500 text-sm">Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
        <hr class="mt-3">
    </div>

    {{-- Stat Cards --}}
    @php
        $totalPendapatan = $bookings->filter(fn($b) => $b->pembayaran && $b->pembayaran->status_pembayaran === 'valid')
                                    ->sum(fn($b) => $b->pembayaran->jumlah ?? 0);
        $totalConfirmed  = $bookings->where('status', 'confirmed')->count();
        $totalCancelled  = $bookings->where('status', 'cancelled')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 print:gap-4">

        {{-- Total Pendapatan --}}
        <div class="bg-blue-600 rounded-2xl shadow-sm p-6 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-blue-200 text-sm font-medium">Total Pendapatan</p>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <p class="text-blue-200 text-xs mt-1">Dari pembayaran yang valid</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Booking Dikonfirmasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Booking Dikonfirmasi</p>
                    <p class="text-3xl font-bold mt-2 text-slate-800">{{ $totalConfirmed }}</p>
                    <p class="text-slate-400 text-xs mt-1">Berhasil dikonfirmasi</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full"
                             style="width: {{ $bookings->count() > 0 ? round(($totalConfirmed / $bookings->count()) * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-xs text-slate-500 font-medium">
                        {{ $bookings->count() > 0 ? round(($totalConfirmed / $bookings->count()) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        {{-- Booking Dibatalkan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-slate-500 text-sm font-medium">Booking Dibatalkan</p>
                    <p class="text-3xl font-bold mt-2 text-slate-800">{{ $totalCancelled }}</p>
                    <p class="text-slate-400 text-xs mt-1">Telah dibatalkan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5">
                        <div class="bg-red-400 h-1.5 rounded-full"
                             style="width: {{ $bookings->count() > 0 ? round(($totalCancelled / $bookings->count()) * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-xs text-slate-500 font-medium">
                        {{ $bookings->count() > 0 ? round(($totalCancelled / $bookings->count()) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- Table Laporan Lengkap --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between print:hidden">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="font-bold text-slate-800 text-base">Data Lengkap Booking</h2>
            </div>
            <span class="text-xs text-slate-500 bg-slate-100 rounded-full px-3 py-1 font-medium">
                {{ $bookings->count() }} total
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Pasien</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Dokter</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Jadwal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-blue-700 uppercase tracking-wider">Jumlah Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $index => $booking)
                    <tr class="hover:bg-slate-50 transition-colors duration-100 print:hover:bg-transparent">

                        <td class="px-4 py-3 text-slate-500 font-medium">{{ $index + 1 }}</td>

                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ $booking->user->name ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->user->email ?? '-' }}</p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ $booking->jadwal->dokter->nama_dokter ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="text-slate-700 capitalize font-medium">{{ $booking->jadwal->hari ?? '-' }}</p>
                            <p class="text-xs text-slate-400">
                                {{ $booking->jadwal->jam_mulai ?? '' }}
                                @if($booking->jadwal->jam_selesai) "“ {{ $booking->jadwal->jam_selesai }} @endif
                            </p>
                        </td>

                        <td class="px-4 py-3 text-slate-600 text-sm">
                            {{ $booking->created_at ? $booking->created_at->format('d M Y') : '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @php
                                $statusMap = [
                                    'pending'   => ['bg-amber-100 text-amber-800', 'Menunggu'],
                                    'confirmed' => ['bg-green-100 text-green-800', 'Dikonfirmasi'],
                                    'cancelled' => ['bg-red-100 text-red-800', 'Dibatalkan'],
                                ];
                                $st = $statusMap[$booking->status] ?? ['bg-slate-100 text-slate-600', ucfirst($booking->status ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $st[0] }}">
                                {{ $st[1] }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-right">
                            @if($booking->pembayaran && $booking->pembayaran->status_pembayaran === 'valid')
                                <p class="font-bold text-slate-800">Rp {{ number_format($booking->pembayaran->jumlah ?? 0, 0, ',', '.') }}</p>
                            @else
                                <p class="text-slate-400 text-xs">"“</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada data laporan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{-- Footer Total --}}
                @if($bookings->count() > 0)
                <tfoot>
                    <tr class="bg-blue-50 border-t-2 border-blue-200">
                        <td colspan="6" class="px-4 py-3 text-sm font-bold text-blue-700 text-right">
                            Total Pendapatan
                        </td>
                        <td class="px-4 py-3 text-right">
                            <p class="font-bold text-blue-700 text-base">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>

{{-- Print Styles --}}
<style>
    @media print {
        body { font-size: 12px; }
        .print\:hidden { display: none !important; }
        .print\:block { display: block !important; }
    }
</style>

@endsection

