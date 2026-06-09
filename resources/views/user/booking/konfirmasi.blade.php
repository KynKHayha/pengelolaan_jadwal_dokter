@extends('layouts.user')
@section('title', 'Detail & Pembayaran Booking')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

    {{-- ===================== BREADCRUMB ===================== --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('user.booking.riwayat') }}" class="hover:text-blue-600 transition-colors">Riwayat</a>
        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-slate-800 font-medium">Detail #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
    </nav>

    {{-- ===================== JUDUL ===================== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail & Pembayaran Booking</h1>
        <p class="text-sm text-slate-500 mt-1">Informasi lengkap booking dan status pembayaran</p>
    </div>

    {{-- ===================== CARD SUMMARY BOOKING ===================== --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="bg-blue-700 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-blue-200 uppercase tracking-wide font-medium">Booking ID</p>
                    <p class="text-white font-bold text-base">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            {{-- Status Badge --}}
            @if($booking->status === 'pending')
                <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>Menunggu Konfirmasi
                </span>
            @elseif($booking->status === 'confirmed')
                <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>Dikonfirmasi
                </span>
            @elseif($booking->status === 'cancelled')
                <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>Dibatalkan
                </span>
            @else
                <span class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                    {{ ucfirst($booking->status) }}
                </span>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Info Dokter --}}
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Informasi Dokter</p>
                    <div class="flex items-center gap-3">
                        @if($booking->jadwal->dokter->foto)
                            <img src="{{ asset('storage/' . $booking->jadwal->dokter->foto) }}"
                                 alt="{{ $booking->jadwal->dokter->nama }}"
                                 class="w-14 h-14 rounded-xl object-cover border border-slate-100 flex-shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center border border-blue-100 flex-shrink-0">
                                <span class="text-xl font-bold text-blue-600">{{ strtoupper(substr($booking->jadwal->dokter->nama, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-slate-800">{{ $booking->jadwal->dokter->nama }}</p>
                            <span class="inline-block mt-1 px-2.5 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                                {{ $booking->jadwal->dokter->spesialisasi }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Info Jadwal --}}
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Informasi Jadwal</p>
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-slate-700">
                                <span class="font-semibold">{{ $booking->jadwal->hari }}</span>,
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-slate-700">{{ substr($booking->jadwal->jam_mulai, 0, 5) }} "“ {{ substr($booking->jadwal->jam_selesai, 0, 5) }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                            <span class="text-sm text-slate-700">{{ $booking->jadwal->ruangan->nama_ruangan ?? 'Ruang Umum' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keluhan --}}
            @if($booking->keluhan)
            <div class="mt-5 pt-5 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Keluhan / Keterangan</p>
                <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">{{ $booking->keluhan }}</p>
            </div>
            @endif

            {{-- Catatan Admin --}}
            @if($booking->catatan_admin)
            <div class="mt-4">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.008v.008H12v-.008z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Catatan dari Admin</p>
                        <p class="text-sm text-amber-700 mt-1 leading-relaxed">{{ $booking->catatan_admin }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Footer: tanggal dibuat --}}
            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Dibuat pada {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }} WIB
            </div>
        </div>
    </div>

    {{-- ===================== SECTION PEMBAYARAN ===================== --}}
    @if($booking->pembayaran)
    {{-- -------- Ada Pembayaran: Tampilkan Status -------- --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Informasi Pembayaran</h3>
                <p class="text-sm text-slate-500 mt-0.5">Detail bukti pembayaran yang telah diunggah</p>
            </div>
            @if($booking->pembayaran->status_pembayaran === 'pending')
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>Menunggu Verifikasi
                </span>
            @elseif($booking->pembayaran->status_pembayaran === 'valid')
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>Terverifikasi
                </span>
            @elseif($booking->pembayaran->status_pembayaran === 'invalid')
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>Tidak Valid
                </span>
            @endif
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Info Pembayaran --}}
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Jumlah Pembayaran</p>
                        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($booking->pembayaran->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Metode Pembayaran</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $booking->pembayaran->metode_pembayaran ?? '-' }}</p>
                    </div>
                    @if($booking->pembayaran->catatan)
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">Catatan Admin</p>
                        <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-xl px-4 py-3 border border-slate-100">{{ $booking->pembayaran->catatan }}</p>
                    </div>
                    @endif
                </div>

                {{-- Bukti Transfer --}}
                @if($booking->pembayaran->bukti_transfer)
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Bukti Transfer</p>
                    <a href="{{ asset('storage/' . $booking->pembayaran->bukti_transfer) }}" target="_blank"
                       class="block group relative overflow-hidden rounded-xl border border-slate-200 hover:border-blue-300 transition-colors">
                        <img src="{{ asset('storage/' . $booking->pembayaran->bukti_transfer) }}"
                             alt="Bukti Transfer"
                             class="w-full h-40 object-cover group-hover:opacity-90 transition-opacity">
                        <div class="absolute inset-0 bg-blue-900/0 group-hover:bg-blue-900/20 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-lg">
                                Buka Ukuran Penuh
                            </span>
                        </div>
                    </a>
                    <p class="text-xs text-slate-400 mt-2 text-center">Klik untuk membuka gambar</p>
                </div>
                @endif
            </div>

            {{-- Alert Box Sesuai Status --}}
            <div class="mt-5">
                @if($booking->pembayaran->status_pembayaran === 'pending')
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Sedang Diverifikasi</p>
                        <p class="text-xs text-amber-700 mt-1">Bukti transfer Anda sedang dalam proses verifikasi oleh admin. Mohon tunggu konfirmasi lebih lanjut.</p>
                    </div>
                </div>
                @elseif($booking->pembayaran->status_pembayaran === 'valid')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-green-800">Pembayaran Terverifikasi</p>
                        <p class="text-xs text-green-700 mt-1">Pembayaran Anda telah diverifikasi. Harap datang tepat waktu sesuai jadwal yang telah ditentukan.</p>
                    </div>
                </div>
                @elseif($booking->pembayaran->status_pembayaran === 'invalid')
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-800">Bukti Pembayaran Tidak Valid</p>
                        <p class="text-xs text-red-700 mt-1">Bukti transfer yang Anda unggah tidak valid. Silakan hubungi admin atau upload ulang bukti yang benar.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    @elseif($booking->status !== 'cancelled')
    {{-- -------- Belum Ada Pembayaran: Form Upload -------- --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-base">Upload Bukti Pembayaran</h3>
            <p class="text-sm text-slate-500 mt-0.5">Unggah bukti transfer untuk konfirmasi booking</p>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('user.booking.upload-bukti', $booking->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Jumlah Pembayaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Jumlah Pembayaran
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-sm font-semibold text-slate-500">Rp</span>
                            </div>
                            <input type="number"
                                   name="jumlah"
                                   value="{{ old('jumlah') }}"
                                   placeholder="0"
                                   min="0"
                                   class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 outline-none transition-shadow @error('jumlah') border-red-400 bg-red-50 @enderror">
                        </div>
                        @error('jumlah')
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Metode Pembayaran
                            <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <select name="metode_pembayaran"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-700 outline-none transition-shadow @error('metode_pembayaran') border-red-400 bg-red-50 @enderror">
                            <option value="">-- Pilih Metode --</option>
                            <option value="Transfer Bank" {{ old('metode_pembayaran') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="GoPay" {{ old('metode_pembayaran') === 'GoPay' ? 'selected' : '' }}>GoPay</option>
                            <option value="OVO" {{ old('metode_pembayaran') === 'OVO' ? 'selected' : '' }}>OVO</option>
                            <option value="DANA" {{ old('metode_pembayaran') === 'DANA' ? 'selected' : '' }}>DANA</option>
                            <option value="ShopeePay" {{ old('metode_pembayaran') === 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                            <option value="BCA Virtual Account" {{ old('metode_pembayaran') === 'BCA Virtual Account' ? 'selected' : '' }}>BCA Virtual Account</option>
                            <option value="Mandiri Virtual Account" {{ old('metode_pembayaran') === 'Mandiri Virtual Account' ? 'selected' : '' }}>Mandiri Virtual Account</option>
                        </select>
                        @error('metode_pembayaran')
                            <p class="text-xs text-red-600 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Bukti Transfer Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Bukti Transfer
                        <span class="text-red-500 ml-0.5">*</span>
                    </label>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl overflow-hidden @error('bukti_transfer') border-red-400 @enderror">
                        {{-- Placeholder Upload --}}
                        <div id="upload-placeholder" class="p-8 text-center cursor-pointer hover:bg-slate-50 transition-colors" onclick="document.getElementById('bukti-input').click()">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-700">Klik untuk unggah bukti transfer</p>
                            <p class="text-xs text-slate-400 mt-1">PNG, JPG, JPEG maksimal 2MB</p>
                        </div>

                        {{-- Preview --}}
                        <div id="image-preview" class="hidden relative">
                            <img id="preview-img" src="" alt="Preview" class="w-full max-h-64 object-contain bg-slate-50">
                            <button type="button"
                                    onclick="document.getElementById('bukti-input').click()"
                                    class="absolute bottom-3 right-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
                                Ganti Foto
                            </button>
                        </div>
                    </div>

                    <input type="file"
                           id="bukti-input"
                           name="bukti_transfer"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(this)">

                    @error('bukti_transfer')
                        <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('user.booking.riwayat') }}"
                       class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                        Kembali
                    </a>
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        Upload Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    @else
    {{-- -------- Booking Dibatalkan -------- --}}
    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 flex gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.008v.008H12v-.008z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-red-800 text-base">Booking Dibatalkan</h3>
            <p class="text-sm text-red-700 mt-1 leading-relaxed">
                Booking ini telah dibatalkan dan tidak dapat diproses lebih lanjut.
                Silakan buat booking baru untuk mendapatkan jadwal dokter.
            </p>
            <a href="{{ route('user.cari-jadwal') }}"
               class="inline-flex items-center gap-2 mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/>
                </svg>
                Cari Jadwal Baru
            </a>
        </div>
    </div>
    @endif

    {{-- ===================== LINK KEMBALI ===================== --}}
    <div class="flex items-center justify-start pt-2">
        <a href="{{ route('user.booking.riwayat') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Kembali ke Riwayat
        </a>
    </div>

</div>

{{-- ===================== JAVASCRIPT ===================== --}}
@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection

