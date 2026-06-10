@extends('layouts.user')
@section('title', 'Riwayat Booking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    {{-- ===================== HEADER ===================== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Booking</h1>
            <p class="text-sm text-slate-500 mt-1">
                Total <span class="font-semibold text-slate-700">{{ $bookings->total() }}</span> data booking
            </p>
        </div>
        <a href="{{ route('user.cari-jadwal') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Buat Booking Baru
        </a>
    </div>

    {{-- ===================== FILTER TABS ===================== --}}
    <div class="flex flex-wrap gap-2">
        @php
            $tabs = [
                '' => 'Semua',
                'pending' => 'Menunggu',
                'confirmed' => 'Dikonfirmasi',
                'cancelled' => 'Dibatalkan',
            ];
            $currentStatus = request('status', '');
        @endphp

        @foreach($tabs as $value => $label)
            <a href="{{ route('user.booking.riwayat', array_filter(['status' => $value])) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold transition-colors duration-150
                      {{ $currentStatus === $value
                          ? 'bg-blue-600 text-white shadow-sm'
                          : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                @if($value === 'pending')
                    <span class="w-2 h-2 rounded-full {{ $currentStatus === $value ? 'bg-amber-300' : 'bg-amber-400' }}"></span>
                @elseif($value === 'confirmed')
                    <span class="w-2 h-2 rounded-full {{ $currentStatus === $value ? 'bg-green-300' : 'bg-green-500' }}"></span>
                @elseif($value === 'cancelled')
                    <span class="w-2 h-2 rounded-full {{ $currentStatus === $value ? 'bg-red-300' : 'bg-red-400' }}"></span>
                @endif
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===================== TABLE CARD ===================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($bookings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide w-10">No</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Dokter</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Jadwal</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Tgl Booking</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Pembayaran</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-blue-700 uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($bookings as $index => $booking)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-100">
                        {{-- No --}}
                        <td class="px-5 py-4">
                            <span class="text-sm text-slate-400 font-medium">{{ $bookings->firstItem() + $index }}</span>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($booking->jadwal->dokter->foto)
                                    <img src="{{ asset('storage/' . $booking->jadwal->dokter->foto) }}"
                                         alt="{{ $booking->jadwal->dokter->nama }}"
                                         class="w-9 h-9 rounded-lg object-cover border border-slate-100 flex-shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center border border-blue-100 flex-shrink-0">
                                        <span class="text-sm font-bold text-blue-600">{{ strtoupper(substr($booking->jadwal->dokter->nama, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-slate-800 whitespace-nowrap">{{ $booking->jadwal->dokter->nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->jadwal->dokter->spesialisasi }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Jadwal --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-slate-700 whitespace-nowrap">{{ $booking->jadwal->hari }}</p>
                            <p class="text-xs text-slate-400 whitespace-nowrap">{{ substr($booking->jadwal->jam_mulai, 0, 5) }} "“ {{ substr($booking->jadwal->jam_selesai, 0, 5) }}</p>
                        </td>

                        {{-- Tgl Booking --}}
                        <td class="px-5 py-4">
                            <p class="text-sm text-slate-700 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            @if($booking->status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>Menunggu
                                </span>
                            @elseif($booking->status === 'confirmed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>Dikonfirmasi
                                </span>
                            @elseif($booking->status === 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- Pembayaran --}}
                        <td class="px-5 py-4">
                            @if($booking->pembayaran)
                                @if($booking->pembayaran->status_pembayaran === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>Verifikasi
                                    </span>
                                @elseif($booking->pembayaran->status_pembayaran === 'valid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>Valid
                                    </span>
                                @elseif($booking->pembayaran->status_pembayaran === 'invalid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>Tidak Valid
                                    </span>
                                @endif
                            @elseif($booking->status !== 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                    Belum Upload
                                </span>
                            @else
                                <span class="text-xs text-slate-300">–</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('user.booking.konfirmasi', $booking->id) }}"
                                   class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold px-3 py-1.5 rounded-lg text-xs transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Detail
                                </a>

                                @if($booking->status === 'pending' && !$booking->pembayaran)
                                <form method="POST" action="{{ route('user.booking.cancel', $booking->id) }}"
                                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-3 py-1.5 rounded-lg text-xs transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Batalkan
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        {{-- Empty State --}}
        <div class="p-16 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
            </div>
            <p class="text-slate-700 font-bold text-lg">
                @if($currentStatus)
                    Tidak ada booking dengan status "{{ $tabs[$currentStatus] ?? $currentStatus }}"
                @else
                    Belum ada riwayat booking
                @endif
            </p>
            <p class="text-slate-400 text-sm mt-2 mb-6 max-w-xs mx-auto">
                @if($currentStatus)
                    Coba pilih tab lain atau buat booking baru
                @else
                    Mulai buat booking dengan mencari jadwal dokter yang tersedia
                @endif
            </p>
            <a href="{{ route('user.cari-jadwal') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                </svg>
                Cari Jadwal Dokter
            </a>
        </div>
        @endif
    </div>

</div>
@endsection

