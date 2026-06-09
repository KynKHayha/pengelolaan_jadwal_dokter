@extends('layouts.admin')
@section('page-title', 'Data Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Pengguna</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar semua pengguna yang terdaftar di sistem</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-slate-500 bg-white border border-slate-100 rounded-xl px-4 py-2 shadow-sm">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Total: <strong class="text-slate-700">{{ $penggunas->total() }}</strong> pengguna</span>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Total Booking</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-blue-700 uppercase tracking-wider">Bergabung</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-blue-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penggunas as $index => $pengguna)
                    <tr class="hover:bg-slate-50 transition-colors duration-100">

                        {{-- No --}}
                        <td class="px-4 py-3 text-slate-500 font-medium">
                            {{ $penggunas->firstItem() + $index }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($pengguna->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <p class="font-semibold text-slate-800">{{ $pengguna->name }}</p>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-4 py-3 text-slate-600">
                            {{ $pengguna->email }}
                        </td>

                        {{-- Total Booking --}}
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold bg-blue-100 text-blue-700">
                                {{ $pengguna->bookings_count ?? $pengguna->bookings->count() }} booking
                            </span>
                        </td>

                        {{-- Bergabung --}}
                        <td class="px-4 py-3 text-slate-600 text-sm">
                            {{ $pengguna->created_at ? $pengguna->created_at->format('d M Y') : '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.pengguna.show', $pengguna->id) }}"
                               class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada pengguna terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($penggunas->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $penggunas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

