@extends('layouts.admin')
@section('page-title', 'Kelola Booking')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Booking</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola semua data booking pasien</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500 bg-white border border-slate-100 rounded-xl px-4 py-2 shadow-sm">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Total: <strong class="text-slate-700">{{ $bookings->total() }}</strong> booking</span>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-2">
        @php
            $currentStatus = request('status', '');
            $tabs = [
                '' => 'Semua',
                'pending' => 'Menunggu',
                'confirmed' => 'Dikonfirmasi',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp
        @foreach($tabs as $value => $label)
            <a href="{{ route('admin.booking.index', $value ? ['status' => $value] : []) }}"
               class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-150
                      {{ $currentStatus === $value
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'bg-white border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $index => $booking)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">
                        {{-- No --}}
                        <td class="px-4 py-3 text-slate-500 font-medium">
                            {{ $bookings->firstItem() + $index }}
                        </td>

                        {{-- Pasien --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-700 font-bold text-xs">
                                        {{ strtoupper(substr($booking->user->name ?? 'P', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $booking->user->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800 text-sm">{{ $booking->jadwal->dokter->nama_dokter ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </td>

                        {{-- Jadwal --}}
                        <td class="px-4 py-3">
                            <p class="text-sm text-slate-700 font-medium capitalize">{{ $booking->jadwal->hari ?? '-' }}</p>
                            <p class="text-xs text-slate-400">
                                {{ $booking->jadwal->jam_mulai ?? '' }}
                                @if($booking->jadwal->jam_selesai) – {{ $booking->jadwal->jam_selesai }} @endif
                            </p>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-3 text-sm text-slate-600">
                            {{ $booking->created_at ? $booking->created_at->format('d M Y') : '-' }}
                        </td>

                        {{-- Status Booking --}}
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

                        {{-- Pembayaran --}}
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

                        {{-- Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.booking.show', $booking->id) }}"
                               class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data booking</p>
                                <p class="text-slate-400 text-xs">Belum ada booking yang sesuai filter ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

