@extends('layouts.admin')
@section('page-title', 'Detail Pembayaran')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pembayaran.index') }}"
           class="p-2 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-0.5">ID: <span class="font-mono text-blue-600">#{{ $pembayaran->id }}</span></p>
        </div>
    </div>

    {{-- 2-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: col-span-2 --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card Ringkasan Booking --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Ringkasan Booking</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Pasien</p>
                            <p class="text-slate-800 font-semibold">{{ $pembayaran->booking->user->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $pembayaran->booking->user->email ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Dokter</p>
                            <p class="text-slate-800 font-semibold">{{ $pembayaran->booking->jadwal->dokter->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $pembayaran->booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jadwal</p>
                            <p class="text-slate-800 font-semibold capitalize">{{ $pembayaran->booking->jadwal->hari ?? '-' }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $pembayaran->booking->jadwal->jam_mulai ?? '' }}
                                @if($pembayaran->booking->jadwal->jam_selesai) "“ {{ $pembayaran->booking->jadwal->jam_selesai }} @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Booking</p>
                            <p class="text-slate-800 font-semibold">
                                {{ $pembayaran->booking->created_at ? $pembayaran->booking->created_at->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Booking</p>
                            @php
                                $statusMap = [
                                    'pending'   => ['bg-amber-100 text-amber-800', 'Menunggu'],
                                    'confirmed' => ['bg-green-100 text-green-800', 'Dikonfirmasi'],
                                    'cancelled' => ['bg-red-100 text-red-800', 'Dibatalkan'],
                                ];
                                $st = $statusMap[$pembayaran->booking->status ?? ''] ?? ['bg-slate-100 text-slate-600', ucfirst($pembayaran->booking->status ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $st[0] }}">
                                {{ $st[1] }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Card Detail Pembayaran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Detail Pembayaran</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jumlah Pembayaran</p>
                            <p class="text-3xl font-bold text-slate-800">
                                Rp {{ number_format($pembayaran->jumlah ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Metode Pembayaran</p>
                            <p class="text-slate-800 font-semibold capitalize">{{ $pembayaran->metode_pembayaran ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                            @php
                                $bayarMap = [
                                    'pending' => ['bg-amber-100 text-amber-800', 'Menunggu Verifikasi'],
                                    'valid'   => ['bg-green-100 text-green-800', 'Valid'],
                                    'invalid' => ['bg-red-100 text-red-800', 'Tidak Valid'],
                                ];
                                $bp = $bayarMap[$pembayaran->status_pembayaran] ?? ['bg-slate-100 text-slate-600', ucfirst($pembayaran->status_pembayaran ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $bp[0] }}">
                                {{ $bp[1] }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pembayaran</p>
                            <p class="text-slate-800 font-semibold">
                                {{ $pembayaran->created_at ? $pembayaran->created_at->format('d M Y') : '-' }}
                            </p>
                            <p class="text-sm text-slate-500">
                                {{ $pembayaran->created_at ? $pembayaran->created_at->format('H:i') . ' WIB' : '' }}
                            </p>
                        </div>

                    </div>

                    {{-- Bukti Transfer --}}
                    @if($pembayaran->bukti_transfer)
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Bukti Transfer</p>
                        <div class="relative inline-block group cursor-pointer"
                             onclick="document.getElementById('imgModalPembayaran').classList.remove('hidden')">
                            <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}"
                                 alt="Bukti Transfer"
                                 class="w-56 h-56 object-cover rounded-xl border border-slate-200 group-hover:opacity-90 transition-opacity shadow-sm">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-black/60 text-white rounded-full p-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">Klik gambar untuk memperbesar</p>
                    </div>

                    {{-- Modal Preview --}}
                    <div id="imgModalPembayaran"
                         class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4"
                         onclick="this.classList.add('hidden')">
                        <div class="relative max-w-3xl w-full">
                            <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}"
                                 alt="Bukti Transfer"
                                 class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl">
                            <button onclick="document.getElementById('imgModalPembayaran').classList.add('hidden')"
                                    class="absolute top-3 right-3 bg-white/20 hover:bg-white/40 text-white rounded-full p-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- Catatan Admin --}}
                    @if($pembayaran->catatan)
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Catatan Admin</p>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-amber-800 text-sm leading-relaxed">{{ $pembayaran->catatan }}</p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="space-y-6">

            @if($pembayaran->status_pembayaran === 'pending')
            {{-- Card Verifikasi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Verifikasi Pembayaran</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.pembayaran.verify', $pembayaran) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Pembayaran</label>
                            <select name="status_pembayaran"
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="valid">Valid "“ Pembayaran Diterima</option>
                                <option value="invalid">Tidak Valid "“ Tolak Pembayaran</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Catatan</label>
                            <textarea name="catatan" rows="4"
                                      placeholder="Tambahkan catatan verifikasi..."
                                      class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none">{{ $pembayaran->catatan }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2.5 text-sm font-semibold transition-colors duration-150 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Simpan Verifikasi
                        </button>
                    </form>
                </div>
            </div>

            @else
            {{-- Sudah Diverifikasi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg {{ $pembayaran->status_pembayaran === 'valid' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                        @if($pembayaran->status_pembayaran === 'valid')
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        @endif
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Status Verifikasi</h2>
                </div>
                <div class="p-6 text-center">
                    @if($pembayaran->status_pembayaran === 'valid')
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="font-bold text-green-700 text-lg">Pembayaran Valid</p>
                    <p class="text-sm text-slate-500 mt-1">Pembayaran telah diverifikasi dan diterima</p>
                    @else
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <p class="font-bold text-red-700 text-lg">Pembayaran Ditolak</p>
                    <p class="text-sm text-slate-500 mt-1">Pembayaran tidak valid dan telah ditolak</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Kembali ke Daftar --}}
            <a href="{{ route('admin.pembayaran.index') }}"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:text-blue-600 hover:border-blue-300 text-sm font-semibold transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Kembali ke Daftar
            </a>

        </div>
    </div>

</div>
@endsection

