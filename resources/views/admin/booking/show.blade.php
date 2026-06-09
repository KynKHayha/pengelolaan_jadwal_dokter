@extends('layouts.admin')
@section('page-title', 'Detail Booking')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.booking.index') }}"
           class="p-2 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-blue-600 hover:border-blue-300 transition-colors duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail Booking</h1>
            <p class="text-sm text-slate-500 mt-0.5">ID: <span class="font-mono text-blue-600">#{{ $booking->id }}</span></p>
        </div>
    </div>

    {{-- 2-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: col-span-2 --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Card Informasi Booking --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Informasi Booking</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Booking ID --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Booking ID</p>
                            <p class="text-slate-800 font-mono font-semibold">#{{ $booking->id }}</p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                            @php
                                $statusMap = [
                                    'pending'   => ['bg-amber-100 text-amber-800', 'Menunggu'],
                                    'confirmed' => ['bg-green-100 text-green-800', 'Dikonfirmasi'],
                                    'cancelled' => ['bg-red-100 text-red-800', 'Dibatalkan'],
                                ];
                                $st = $statusMap[$booking->status] ?? ['bg-slate-100 text-slate-600', ucfirst($booking->status ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $st[0] }}">
                                {{ $st[1] }}
                            </span>
                        </div>

                        {{-- Pasien --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Pasien</p>
                            <p class="text-slate-800 font-semibold">{{ $booking->user->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $booking->user->email ?? '-' }}</p>
                        </div>

                        {{-- Dokter --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Dokter</p>
                            <p class="text-slate-800 font-semibold">{{ $booking->jadwal->dokter->name ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </div>

                        {{-- Jadwal --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jadwal</p>
                            <p class="text-slate-800 font-semibold capitalize">{{ $booking->jadwal->hari ?? '-' }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $booking->jadwal->jam_mulai ?? '' }}
                                @if($booking->jadwal->jam_selesai) "“ {{ $booking->jadwal->jam_selesai }} @endif
                            </p>
                            @if($booking->jadwal->ruangan)
                            <p class="text-xs text-slate-400 mt-0.5">Ruangan: {{ $booking->jadwal->ruangan }}</p>
                            @endif
                        </div>

                        {{-- Tanggal Booking --}}
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Booking</p>
                            <p class="text-slate-800 font-semibold">
                                {{ $booking->created_at ? $booking->created_at->format('d M Y') : '-' }}
                            </p>
                            <p class="text-sm text-slate-500">
                                {{ $booking->created_at ? $booking->created_at->format('H:i') . ' WIB' : '' }}
                            </p>
                        </div>

                        {{-- Keluhan --}}
                        @if($booking->keluhan)
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Keluhan</p>
                            <p class="text-slate-700 bg-slate-50 rounded-lg px-4 py-3 text-sm leading-relaxed">{{ $booking->keluhan }}</p>
                        </div>
                        @endif

                        {{-- Catatan Admin --}}
                        @if($booking->catatan_admin)
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Catatan Admin</p>
                            <p class="text-slate-700 bg-blue-50 rounded-lg px-4 py-3 text-sm leading-relaxed border-l-4 border-blue-400">{{ $booking->catatan_admin }}</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Card Informasi Pembayaran --}}
            @if($booking->pembayaran)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Informasi Pembayaran</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Jumlah</p>
                            <p class="text-2xl font-bold text-slate-800">
                                Rp {{ number_format($booking->pembayaran->jumlah ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Metode Pembayaran</p>
                            <p class="text-slate-800 font-semibold capitalize">{{ $booking->pembayaran->metode ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Pembayaran</p>
                            @php
                                $bayarMap = [
                                    'pending' => ['bg-amber-100 text-amber-800', 'Menunggu Verifikasi'],
                                    'valid'   => ['bg-green-100 text-green-800', 'Valid'],
                                    'invalid' => ['bg-red-100 text-red-800', 'Tidak Valid'],
                                ];
                                $bp = $bayarMap[$booking->pembayaran->status] ?? ['bg-slate-100 text-slate-600', ucfirst($booking->pembayaran->status ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $bp[0] }}">
                                {{ $bp[1] }}
                            </span>
                        </div>

                    </div>

                    {{-- Bukti Transfer --}}
                    @if($booking->pembayaran->bukti_transfer)
                    <div class="mt-6">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Bukti Transfer</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $booking->pembayaran->bukti_transfer) }}"
                                 alt="Bukti Transfer"
                                 class="w-48 h-48 object-cover rounded-xl border border-slate-200 cursor-pointer hover:opacity-90 transition-opacity"
                                 onclick="document.getElementById('imgModal').classList.remove('hidden')">
                            <div class="absolute top-2 right-2 bg-black/50 text-white rounded-md px-2 py-1 text-xs">
                                Klik untuk perbesar
                            </div>
                        </div>
                    </div>
                    {{-- Modal Preview --}}
                    <div id="imgModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4"
                         onclick="this.classList.add('hidden')">
                        <img src="{{ asset('storage/' . $booking->pembayaran->bukti_transfer) }}"
                             alt="Bukti Transfer" class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="space-y-6">

            {{-- Card Update Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h2 class="font-bold text-slate-800 text-base">Update Status</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.booking.update-status', $booking) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Booking</label>
                            <select name="status"
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="pending"   {{ $booking->status === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Catatan Admin</label>
                            <textarea name="catatan_admin" rows="4"
                                      placeholder="Tambahkan catatan untuk pasien..."
                                      class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none">{{ $booking->catatan_admin }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2.5 text-sm font-semibold transition-colors duration-150 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kembali ke Daftar --}}
            <a href="{{ route('admin.booking.index') }}"
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

