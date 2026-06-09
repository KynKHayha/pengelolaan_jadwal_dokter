@extends('layouts.admin')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pengguna.index') }}"
           class="p-2 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Pengguna</h1>
            <p class="text-sm text-slate-500 mt-0.5">Informasi lengkap dan riwayat booking pengguna</p>
        </div>
    </div>

    {{-- Profil Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-800 to-blue-600 px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                {{-- Avatar Besar --}}
                <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <span class="text-white font-bold text-3xl">
                        {{ strtoupper(substr($pengguna->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                {{-- Info --}}
                <div class="text-center sm:text-left">
                    <h2 class="text-xl font-bold text-white">{{ $pengguna->name }}</h2>
                    <p class="text-blue-200 text-sm mt-1">{{ $pengguna->email }}</p>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-3 mt-3">
                        <div class="flex items-center gap-1.5 bg-white/10 rounded-full px-3 py-1">
                            <svg class="w-3.5 h-3.5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-white text-xs font-medium">
                                Bergabung {{ $pengguna->created_at ? $pengguna->created_at->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 bg-white/10 rounded-full px-3 py-1">
                            <svg class="w-3.5 h-3.5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-white text-xs font-medium">
                                {{ $pengguna->bookings->count() }} Booking
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Booking --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="font-bold text-slate-800 text-base">Riwayat Booking</h2>
            <span class="ml-auto bg-blue-100 text-blue-700 text-xs font-semibold rounded-full px-2.5 py-1">
                {{ $pengguna->bookings->count() }} total
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Dokter</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Jadwal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengguna->bookings as $booking)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">

                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ $booking->jadwal->dokter->nama_dokter ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="text-slate-700 font-medium capitalize">{{ $booking->jadwal->hari ?? '-' }}</p>
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

                        <td class="px-4 py-3">
                            @if($booking->pembayaran)
                                @php
                                    $bayarMap = [
                                        'pending' => ['bg-amber-100 text-amber-800', 'Menunggu'],
                                        'valid'   => ['bg-green-100 text-green-800', 'Valid'],
                                        'invalid' => ['bg-red-100 text-red-800', 'Tidak Valid'],
                                    ];
                                    $bp = $bayarMap[$booking->pembayaran->status_pembayaran] ?? ['bg-slate-100 text-slate-600', ucfirst($booking->pembayaran->status_pembayaran)];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $bp[0] }}">
                                    {{ $bp[1] }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-500">
                                    Belum bayar
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">Belum ada riwayat booking</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div>
        <a href="{{ route('admin.pengguna.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-slate-200 bg-white text-slate-600 hover:text-slate-800 hover:border-slate-300 text-sm font-semibold transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

</div>
@endsection

