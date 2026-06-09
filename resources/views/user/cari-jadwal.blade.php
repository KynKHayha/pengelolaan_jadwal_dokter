@extends('layouts.user')
@section('title', 'Cari Jadwal Dokter')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    {{-- ===================== HEADER ===================== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Cari Jadwal Dokter</h1>
        <p class="text-sm text-slate-500 mt-1">Temukan dokter spesialis sesuai kebutuhan dan buat janji temu</p>
    </div>

    {{-- ===================== FILTER CARD ===================== --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <form method="GET" action="{{ route('user.cari-jadwal') }}" class="flex flex-col sm:flex-row gap-3 items-end">
            {{-- Spesialisasi --}}
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Spesialisasi</label>
                <select name="spesialisasi"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 outline-none transition-shadow">
                    <option value="">-- Semua Spesialisasi --</option>
                    @foreach($spesialisasis as $spesialisasi)
                        <option value="{{ $spesialisasi }}" {{ request('spesialisasi') === $spesialisasi ? 'selected' : '' }}>
                            {{ $spesialisasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Hari --}}
            <div class="flex-1 min-w-0">
                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Hari Praktik</label>
                <select name="hari"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 outline-none transition-shadow">
                    <option value="">-- Semua Hari --</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                        <option value="{{ $hari }}" {{ request('hari') === $hari ? 'selected' : '' }}>{{ $hari }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                    </svg>
                    Cari Jadwal
                </button>
                @if(request('spesialisasi') || request('hari'))
                    <a href="{{ route('user.cari-jadwal') }}"
                       class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>

        {{-- Hasil info --}}
        @if(request('spesialisasi') || request('hari'))
        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-2 text-sm text-slate-600">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            Ditemukan <span class="font-semibold text-blue-700 mx-1">{{ $jadwals->count() }}</span> jadwal dokter
            @if(request('spesialisasi'))
                untuk spesialisasi <span class="font-semibold text-slate-800 ml-1">{{ request('spesialisasi') }}</span>
            @endif
            @if(request('hari'))
                pada hari <span class="font-semibold text-slate-800 ml-1">{{ request('hari') }}</span>
            @endif
        </div>
        @endif
    </div>

    {{-- ===================== GRID JADWAL ===================== --}}
    @forelse($jadwals as $jadwal)
    @php
        $bookedCount = $jadwal->bookings->whereIn('status', ['pending','confirmed'])->count();
        $sisaKuota = max(0, $jadwal->kuota - $bookedCount);
    @endphp

    @if($loop->first)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @endif

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
            {{-- Card Header --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="absolute bottom-0 left-0 w-12 h-12 bg-white/5 rounded-full translate-y-6 -translate-x-4"></div>
                <div class="flex items-center gap-3 relative z-10">
                    @if($jadwal->dokter->foto)
                        <img src="{{ asset('storage/' . $jadwal->dokter->foto) }}"
                             alt="{{ $jadwal->dokter->nama }}"
                             class="w-13 h-13 w-12 h-12 rounded-xl object-cover border-2 border-white/30 shadow">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center border-2 border-white/30">
                            <span class="text-lg font-bold text-white">{{ strtoupper(substr($jadwal->dokter->nama, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-white text-sm leading-snug truncate">{{ $jadwal->dokter->nama }}</p>
                        <span class="inline-block mt-1 px-2.5 py-0.5 bg-blue-500/40 text-blue-100 text-xs rounded-full font-medium">
                            {{ $jadwal->dokter->spesialisasi }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-4 space-y-2.5">
                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span><span class="font-semibold text-slate-700">{{ $jadwal->hari }}</span> &bull; {{ substr($jadwal->jam_mulai, 0, 5) }} "“ {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                </div>

                <div class="flex items-center gap-2.5 text-sm text-slate-600">
                    <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                        </svg>
                    </div>
                    <span>{{ $jadwal->ruangan->nama_ruangan ?? 'Ruang Umum' }}</span>
                </div>

                <div class="flex items-center gap-2.5 text-sm">
                    <div class="w-7 h-7 rounded-lg {{ $sisaKuota > 0 ? 'bg-green-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 {{ $sisaKuota > 0 ? 'text-green-500' : 'text-red-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="{{ $sisaKuota > 0 ? 'text-green-700 font-semibold' : 'text-red-600 font-semibold' }}">
                        {{ $sisaKuota > 0 ? 'Sisa ' . $sisaKuota . ' dari ' . $jadwal->kuota . ' kuota' : 'Kuota Penuh' }}
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

    @if($loop->last)
    </div>
    @endif

    @empty
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-16 text-center">
        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
            </svg>
        </div>
        <p class="text-slate-700 font-bold text-lg">Jadwal Tidak Ditemukan</p>
        <p class="text-slate-400 text-sm mt-2 max-w-sm mx-auto">
            @if(request('spesialisasi') || request('hari'))
                Tidak ada jadwal yang cocok dengan filter yang dipilih. Coba ubah filter pencarian.
            @else
                Belum ada jadwal dokter yang tersedia saat ini.
            @endif
        </p>
        @if(request('spesialisasi') || request('hari'))
        <a href="{{ route('user.cari-jadwal') }}"
           class="inline-flex items-center gap-2 mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Hapus Filter
        </a>
        @endif
    </div>
    @endforelse

</div>
@endsection

