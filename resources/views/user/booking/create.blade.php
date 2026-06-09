@extends('layouts.user')
@section('title', 'Buat Booking')

@section('content')
@php
    $bookedCount = $jadwal->bookings->whereIn('status', ['pending','confirmed'])->count();
    $sisaKuota = max(0, $jadwal->kuota - $bookedCount);
    $hariPraktik = $jadwal->hari;
    $hariMap = [
        'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4,
        'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 0
    ];
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-5">

    {{-- ===================== BREADCRUMB ===================== --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('user.cari-jadwal') }}" class="hover:text-blue-600 transition-colors">Cari Jadwal</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Buat Booking</span>
    </nav>

    {{-- ===================== JUDUL ===================== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Buat Booking</h1>
        <p class="text-sm text-slate-500 mt-1">Lengkapi data booking untuk membuat janji dengan dokter</p>
    </div>

    {{-- ===================== GRID KONTEN ===================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ========== LEFT: Info Jadwal (sticky) ========== --}}
        <div class="lg:col-span-2 sticky top-20 space-y-4">

            {{-- Card Info Dokter & Jadwal --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                {{-- Header Biru --}}
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-24 h-24 bg-white/10 rounded-full -translate-x-12 -translate-y-12"></div>
                    <div class="absolute bottom-0 right-0 w-20 h-20 bg-white/10 rounded-full translate-x-10 translate-y-10"></div>

                    <div class="relative z-10">
                        @if($jadwal->dokter->foto)
                            <img src="{{ asset('storage/' . $jadwal->dokter->foto) }}"
                                 alt="{{ $jadwal->dokter->nama_dokter }}"
                                 class="w-20 h-20 rounded-2xl object-cover border-4 border-white/30 mx-auto mb-3 shadow-lg">
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-white/20 border-4 border-white/30 flex items-center justify-center mx-auto mb-3 shadow-lg">
                                <span class="text-3xl font-bold text-white">{{ strtoupper(substr($jadwal->dokter->nama_dokter, 0, 1)) }}</span>
                            </div>
                        @endif
                        <h2 class="font-bold text-white text-base leading-snug">{{ $jadwal->dokter->nama_dokter }}</h2>
                        <span class="inline-block mt-2 px-3 py-1 bg-blue-500/40 text-blue-100 text-xs rounded-full font-medium">
                            {{ $jadwal->dokter->spesialisasi }}
                        </span>
                    </div>
                </div>

                {{-- Body Info --}}
                <div class="p-5 space-y-3">
                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Hari Praktik</p>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ $jadwal->hari }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Jam Praktik</p>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ substr($jadwal->jam_mulai, 0, 5) }} "“ {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Ruangan</p>
                            <p class="font-semibold text-slate-700 mt-0.5">{{ $jadwal->ruangan->nama_ruangan ?? 'Ruang Umum' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg {{ $sisaKuota > 0 ? 'bg-green-50' : 'bg-red-50' }} flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 {{ $sisaKuota > 0 ? 'text-green-500' : 'text-red-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Sisa Kuota</p>
                            <p class="font-bold {{ $sisaKuota > 0 ? 'text-green-600' : 'text-red-600' }} mt-0.5">
                                {{ $sisaKuota > 0 ? $sisaKuota . ' tempat tersedia' : 'Kuota penuh' }}
                            </p>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="flex items-start gap-3 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Biaya Konsultasi</p>
                            @if($jadwal->harga > 0)
                                <p class="font-bold text-green-700 mt-0.5 text-base">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</p>
                            @else
                                <p class="font-semibold text-green-600 mt-0.5">Gratis</p>
                            @endif
                        </div>
                    </div>

                    @if($jadwal->dokter->bio)
                    <div class="pt-3 border-t border-slate-100">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide mb-2">Tentang Dokter</p>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $jadwal->dokter->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ========== RIGHT: Form Booking ========== --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                {{-- Form Header --}}
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-base">Formulir Booking</h3>
                    <p class="text-sm text-slate-500 mt-0.5">Isi data berikut untuk melanjutkan pemesanan</p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('user.booking.store') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

                        {{-- Tanggal Booking --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Tanggal Booking
                                <span class="text-red-500 ml-0.5">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_booking"
                                   value="{{ old('tanggal_booking') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 outline-none transition-shadow @error('tanggal_booking') border-red-400 bg-red-50 @enderror">
                            <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                </svg>
                                Pilih tanggal sesuai hari praktik: <strong class="text-slate-600 ml-1">{{ $hariPraktik }}</strong>
                            </p>
                            @error('tanggal_booking')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Keluhan --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Keluhan / Keterangan
                                <span class="text-slate-400 font-normal text-xs ml-1">(opsional)</span>
                            </label>
                            <textarea name="keluhan"
                                      rows="4"
                                      placeholder="Ceritakan keluhan atau keterangan yang ingin disampaikan kepada dokter..."
                                      class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 outline-none transition-shadow resize-none @error('keluhan') border-red-400 bg-red-50 @enderror">{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Info Biaya --}}
                        @if($jadwal->harga > 0)
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-green-800">Biaya yang perlu dibayarkan</p>
                                <p class="text-lg font-bold text-green-700 mt-0.5">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Info Box Proses --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-blue-800">Proses Setelah Booking</p>
                                <p class="text-xs text-blue-700 mt-1 leading-relaxed">
                                    Setelah booking, Anda perlu mengunggah bukti pembayaran. Admin akan memverifikasi dan mengkonfirmasi jadwal Anda.
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center gap-3 pt-2">
                            <a href="{{ route('user.cari-jadwal') }}"
                               class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                                Batal
                            </a>
                            @if($sisaKuota > 0)
                                <button type="submit"
                                        class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Konfirmasi Booking
                                </button>
                            @else
                                <button disabled
                                        class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-200 text-slate-400 font-semibold px-5 py-2.5 rounded-xl text-sm cursor-not-allowed">
                                    Kuota Penuh
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Restrict date picker to only allow the practice day
(function() {
    const hariPraktik = '{{ $jadwal->hari }}';
    const hariToDay = {
        'Minggu': 0, 'Senin': 1, 'Selasa': 2, 'Rabu': 3,
        'Kamis': 4, 'Jumat': 5, 'Sabtu': 6
    };
    const targetDay = hariToDay[hariPraktik];
    const dateInput = document.querySelector('input[name="tanggal_booking"]');
    if (!dateInput || targetDay === undefined) return;

    // Find next valid date from today
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    function findNextValidDate(from) {
        let d = new Date(from);
        for (let i = 0; i < 14; i++) {
            if (d.getDay() === targetDay) return d;
            d.setDate(d.getDate() + 1);
        }
        return null;
    }

    // Set default to next valid date
    const nextValid = findNextValidDate(today);
    if (nextValid && !dateInput.value) {
        dateInput.value = nextValid.toISOString().split('T')[0];
    }

    // Validate on change
    dateInput.addEventListener('change', function() {
        const selected = new Date(this.value + 'T00:00:00');
        if (selected.getDay() !== targetDay) {
            this.setCustomValidity('Pilih hari ' + hariPraktik + ' saja!');
            this.classList.add('border-red-400', 'bg-red-50');
            // Auto-correct to nearest valid date
            const corrected = findNextValidDate(selected);
            if (corrected) {
                setTimeout(() => {
                    this.value = corrected.toISOString().split('T')[0];
                    this.setCustomValidity('');
                    this.classList.remove('border-red-400', 'bg-red-50');
                }, 200);
            }
        } else {
            this.setCustomValidity('');
            this.classList.remove('border-red-400', 'bg-red-50');
        }
    });
})();
</script>
@endpush

