@extends('layouts.admin')

@section('page-title', 'Kelola Ruangan')
@section('page-subtitle', 'Daftar semua ruangan praktik')

@section('content')
<div class="space-y-6">

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-6 py-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Daftar Ruangan</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    Total <span class="font-semibold text-blue-600">{{ $ruangans->total() }}</span> ruangan terdaftar
                </p>
            </div>
            <a href="{{ route('admin.ruangan.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan
            </a>
        </div>
    </div>

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

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($ruangans->isEmpty())
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-700 mb-1">Belum Ada Ruangan</h3>
            <p class="text-sm text-slate-400 mb-6 max-w-xs">Belum ada data ruangan yang terdaftar. Mulai tambahkan ruangan pertama Anda.</p>
            <a href="{{ route('admin.ruangan.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Ruangan Pertama
            </a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5 w-12">No</th>
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Nama Ruangan</th>
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Kode</th>
                        <th class="text-left text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Deskripsi</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Jadwal</th>
                        <th class="text-center text-xs font-semibold text-blue-700 uppercase tracking-wider px-6 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($ruangans as $index => $ruangan)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $ruangans->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-800">{{ $ruangan->nama_ruangan }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($ruangan->kode_ruangan)
                            <span class="inline-flex items-center bg-slate-100 text-slate-700 text-xs font-semibold font-mono px-2.5 py-1 rounded-md tracking-wide">
                                {{ $ruangan->kode_ruangan }}
                            </span>
                            @else
                            <span class="text-slate-400 text-sm">"”</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 max-w-xs">
                            @if($ruangan->deskripsi)
                            <span class="truncate block" title="{{ $ruangan->deskripsi }}">{{ Str::limit($ruangan->deskripsi, 60) }}</span>
                            @else
                            <span class="text-slate-400">"”</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full min-w-[2rem]">
                                {{ $ruangan->jadwals_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.ruangan.edit', $ruangan) }}"
                                   class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-lg px-3 py-1.5 text-xs font-medium transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.ruangan.destroy', $ruangan) }}" method="POST"
                                      onsubmit="return confirm('Hapus ruangan {{ addslashes($ruangan->nama_ruangan) }}? Tindakan ini tidak dapat dibatalkan.')">
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
        @if($ruangans->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $ruangans->links() }}
        </div>
        @endif
        @endif
    </div>

</div>
@endsection

