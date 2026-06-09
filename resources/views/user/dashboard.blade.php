@extends('layouts.user')
@section('title', 'Dashboard Pasien')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    {{-- ===================== WELCOME BANNER ===================== --}}
    <div class="bg-blue-700 rounded-2xl p-6 text-white relative overflow-hidden">
        {{-- Background decorations --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full -translate-y-32 translate-x-32 opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-800 rounded-full translate-y-24 -translate-x-16 opacity-30"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            {{-- Kiri: Greeting --}}
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <span class="text-3xl font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="text-sm text-blue-200 mt-0.5">Selamat datang di <span class="font-semibold text-white">DocPlanner</span></p>
                </div>
            </div>

            {{-- Kanan: Stat mini --}}
            <div class="flex items-center gap-3 flex-wrap">
                <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[90px]">
                    <p class="text-2xl font-bold text-white">{{ $totalBooking }}</p>
                    <p class="text-xs text-blue-200 mt-0.5">Total Booking</p>
                </div>
                <div class="bg-amber-400/25 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[90px]">
                    <p class="text-2xl font-bold text-white">{{ $bookingMenunggu }}</p>
                    <p class="text-xs text-amber-200 mt-0.5">Menunggu</p>
                </div>
                <div class="bg-green-400/25 backdrop-blur-sm rounded-xl px-4 py-3 text-center min-w-[90px]">
                    <p class="text-2xl font-bold text-white">{{ $bookingDikonfirmasi }}</p>
                    <p class="text-xs text-green-200 mt-0.5">Dikonfirmasi</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== JADWAL TERSEDIA ===================== --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Jadwal Dokter Tersedia</h2>
                <p class="text-sm text-slate-500">Pilih jadwal dan buat booking dengan mudah</p>
            </div>
            <a href="{{ route('user.cari-jadwal') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($jadwalTersedia->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($jadwalTersedia as $jadwal)
            @php
                $bookedCount = $jadwal->bookings->whereIn('status', ['pending','confirmed'])->count();
                $sisaKuota = $jadwal->kuota - $bookedCount;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
                {{-- Card Header --}}
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                    <div class="flex items-center gap-3 relative z-10">
                        @if($jadwal->dokter->foto)
                            <img src="{{ asset('storage/' . $jadwal->dokter->foto) }}"
                                 alt="{{ $jadwal->dokter->nama }}"
                                 class="w-12 h-12 rounded-xl object-cover border-2 border-white/30">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center border-2 border-white/30">
                                <span class="text-lg font-bold text-white">{{ strtoupper(substr($jadwal->dokter->nama, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-white text-sm leading-snug">{{ $jadwal->dokter->nama }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-blue-500/40 text-blue-100 text-xs rounded-full font-medium">
                                {{ $jadwal->dokter->spesialisasi }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-4 space-y-2.5">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium text-slate-700">{{ $jadwal->hari }}</span>
                        <span class="text-slate-400">"¢</span>
                        <span>{{ substr($jadwal->jam_mulai, 0, 5) }} "“ {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $jadwal->ruangan->nama_ruangan ?? 'Ruang Umum' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $sisaKuota > 0 ? 'text-green-500' : 'text-red-400' }} flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="{{ $sisaKuota > 0 ? 'text-green-700' : 'text-red-600' }} font-medium">
                            {{ $sisaKuota > 0 ? 'Sisa ' . $sisaKuota . ' kuota' : 'Kuota penuh' }}
                        </span>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="px-4 pb-4">
                    @if($sisaKuota > 0)
                        <a href="{{ route('user.booking.create', $jadwal->id) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                            Buat Booking
                        </a>
                    @else
                        <button disabled
                                class="block w-full text-center bg-slate-100 text-slate-400 font-semibold px-5 py-2.5 rounded-xl text-sm cursor-not-allowed">
                            Kuota Penuh
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                </svg>
            </div>
            <p class="text-slate-700 font-semibold text-base">Belum ada jadwal tersedia</p>
            <p class="text-slate-400 text-sm mt-1">Coba cari jadwal dokter yang sesuai kebutuhanmu</p>
        </div>
        @endif
    </div>

    {{-- ===================== BOOKING TERAKHIR ===================== --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Booking Terakhir</h2>
                <p class="text-sm text-slate-500">Pantau status booking kamu</p>
            </div>
            <a href="{{ route('user.booking.riwayat') }}"
               class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($recentBookings->count() > 0)
        <div class="space-y-3">
            @foreach($recentBookings as $booking)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:shadow-md transition-shadow duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    {{-- Info --}}
                    <div class="flex items-center gap-3">
                        @if($booking->jadwal->dokter->foto)
                            <img src="{{ asset('storage/' . $booking->jadwal->dokter->foto) }}"
                                 alt="{{ $booking->jadwal->dokter->nama }}"
                                 class="w-11 h-11 rounded-xl object-cover border border-slate-100">
                        @else
                            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100">
                                <span class="text-base font-bold text-blue-600">{{ strtoupper(substr($booking->jadwal->dokter->nama, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $booking->jadwal->dokter->nama }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $booking->jadwal->hari }}, {{ substr($booking->jadwal->jam_mulai, 0, 5) }} "“ {{ substr($booking->jadwal->jam_selesai, 0, 5) }}
                                <span class="mx-1 text-slate-300">"¢</span>
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Badge & Aksi --}}
                    <div class="flex items-center gap-2 flex-wrap">
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                {{ ucfirst($booking->status) }}
                            </span>
                        @endif

                        <a href="{{ route('user.booking.konfirmasi', $booking->id) }}"
                           class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold px-3 py-1.5 rounded-lg text-xs transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                </svg>
            </div>
            <p class="text-slate-700 font-semibold text-base">Belum ada booking</p>
            <p class="text-slate-400 text-sm mt-1 mb-5">Mulai buat booking dengan mencari jadwal dokter</p>
            <a href="{{ route('user.cari-jadwal') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                </svg>
                Cari Jadwal
            </a>
        </div>
        @endif
    </div>

</div>
@endsection

