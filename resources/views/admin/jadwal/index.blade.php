@extends('layouts.admin')

@section('page-title', 'Kelola Jadwal')
@section('page-subtitle', 'Manajemen jadwal praktik dokter')

@section('content')
<div class="space-y-6">

    {{-- Alert Messages --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Filter Tabs Hari --}}
    @php
        $hariList = ['Semua', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $activeHari = request('hari', 'Semua');
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-1.5">
        <div class="flex flex-wrap gap-1">
            @foreach($hariList as $hari)
            @php
                $isActive = $activeHari === $hari || ($hari === 'Semua' && !request('hari'));
                $href = $hari === 'Semua' ? route('admin.jadwal.index') : route('admin.jadwal.index', ['hari' => $hari]);
            @endphp
            <a href="{{ $href }}"
               class="{{ $isActive
                   ? 'bg-blue-600 text-white shadow-sm'
                   : 'bg-transparent text-slate-600 hover:bg-slate-100' }}
                   rounded-lg px-4 py-2 text-sm font-medium transition-all duration-150">
                {{ $hari }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-6 py-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Jadwal Praktik
                    @if(request('hari'))
                    <span class="text-blue-600">"” {{ request('hari') }}</span>
                    @endif
                </h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    Total <span class="font-semibold text-blue-600">{{ $jadwals->total() }}</span> jadwal
                    @if(request('hari'))ditemukan untuk hari {{ request('hari') }}@endif
                </p>
            </div>
            <a href="{{ route('admin.jadwal.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($jadwals->isEmpty())
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-700 mb-1">Belum Ada Jadwal</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-xs">
                @if(request('hari'))
                    Tidak ada jadwal untuk hari {{ request('hari') }}.
                @else
                    Belum ada jadwal praktik yang dibuat. Mulai tambahkan jadwal pertama Anda.
                @endif
            </p>
            <a href="{{ route('admin.jadwal.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5 w-12">No</th>
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Dokter</th>
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Ruangan</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Hari</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Jam Praktik</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Kuota</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Status</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Booking</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($jadwals as $index => $jadwal)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $jadwals->firstItem() + $index }}</td>

                        {{-- Dokter --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if(isset($jadwal->dokter->foto) && $jadwal->dokter->foto)
                                <img src="{{ asset('storage/' . $jadwal->dokter->foto) }}"
                                     alt="{{ $jadwal->dokter->nama_dokter ?? '' }}"
                                     class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-100 flex-shrink-0">
                                @else
                                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0 ring-2 ring-blue-100">
                                    <span class="text-white text-xs font-bold">
                                        {{ strtoupper(substr($jadwal->dokter->nama_dokter ?? 'D', 0, 1)) }}
                                    </span>
                                </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $jadwal->dokter->nama_dokter ?? '"”' }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $jadwal->dokter->spesialisasi ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Ruangan --}}
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $jadwal->ruangan->nama_ruangan ?? '"”' }}</p>
                                @if(isset($jadwal->ruangan->kode_ruangan) && $jadwal->ruangan->kode_ruangan)
                                <span class="text-xs font-mono text-slate-400">{{ $jadwal->ruangan->kode_ruangan }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Hari --}}
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center bg-purple-100 text-purple-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                {{ $jadwal->hari }}
                            </span>
                        </td>

                        {{-- Jam Praktik --}}
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-medium text-slate-700">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                "“
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                        </td>

                        {{-- Kuota --}}
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-semibold text-slate-700">{{ $jadwal->kuota ?? 0 }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @if($jadwal->is_active)
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>

                        {{-- Booking --}}
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full min-w-[2rem]">
                                {{ $jadwal->bookings_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.jadwal.edit', $jadwal) }}"
                                   class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-lg px-3 py-1.5 text-xs font-medium transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST"
                                      onsubmit="return confirm('Hapus jadwal ini? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg px-3 py-1.5 text-xs font-medium transition-colors duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($jadwals->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $jadwals->appends(request()->query())->links() }}
        </div>
        @endif
        @endif
    </div>

</div>
@endsection

