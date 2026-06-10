@extends('layouts.admin')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h1>
            <p class="text-sm text-slate-500 mt-1">Verifikasi bukti pembayaran dari pasien</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500 bg-white border border-slate-100 rounded-xl px-4 py-2 shadow-sm">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Total: <strong class="text-slate-700">{{ $pembayarans->total() }}</strong> pembayaran</span>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-2">
        @php
            $currentStatus = request('status', '');
            $tabs = [
                ''        => 'Semua',
                'pending' => 'Menunggu',
                'valid'   => 'Valid',
                'invalid' => 'Tidak Valid',
            ];
        @endphp
        @foreach($tabs as $value => $label)
            <a href="{{ route('admin.pembayaran.index', $value ? ['status' => $value] : []) }}"
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Metode</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pembayarans as $index => $pembayaran)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">

                        {{-- No --}}
                        <td class="px-4 py-3 text-slate-500 font-medium">
                            {{ $pembayarans->firstItem() + $index }}
                        </td>

                        {{-- Pasien --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-blue-700 font-bold text-xs">
                                        {{ strtoupper(substr($pembayaran->booking->user->name ?? 'P', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $pembayaran->booking->user->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-400">{{ $pembayaran->booking->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800 text-sm">{{ $pembayaran->booking->jadwal->dokter->nama_dokter ?? '-' }}</p>
                            <p class="text-xs text-slate-400">{{ $pembayaran->booking->jadwal->dokter->spesialisasi ?? '-' }}</p>
                        </td>

                        {{-- Jumlah --}}
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-800">Rp {{ number_format($pembayaran->jumlah ?? 0, 0, ',', '.') }}</p>
                        </td>

                        {{-- Metode --}}
                        <td class="px-4 py-3 text-slate-600 capitalize">
                            {{ $pembayaran->metode_pembayaran ?? '-' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3">
                            @php
                                $bayarMap = [
                                    'pending' => ['bg-amber-100 text-amber-800', 'Menunggu'],
                                    'valid'   => ['bg-green-100 text-green-800', 'Valid'],
                                    'invalid' => ['bg-red-100 text-red-800', 'Tidak Valid'],
                                ];
                                $bp = $bayarMap[$pembayaran->status_pembayaran] ?? ['bg-slate-100 text-slate-600', ucfirst($pembayaran->status ?? '-')];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $bp[0] }}">
                                {{ $bp[1] }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-3 text-slate-600 text-sm">
                            {{ $pembayaran->created_at ? $pembayaran->created_at->format('d M Y') : '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}"
                               class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data pembayaran</p>
                                <p class="text-slate-400 text-xs">Belum ada pembayaran yang sesuai filter ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pembayarans->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $pembayarans->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

