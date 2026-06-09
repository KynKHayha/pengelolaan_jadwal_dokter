@extends('layouts.admin')

@section('page-title', 'Edit Ruangan')
@section('page-subtitle', 'Perbarui informasi ruangan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.ruangan.index') }}" class="hover:text-blue-600 transition-colors">Kelola Ruangan</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-blue-600 font-medium">Edit Ruangan</span>
    </nav>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Edit Data Ruangan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Memperbarui data: <span class="font-semibold text-amber-600">{{ $ruangan->nama_ruangan }}</span></p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.ruangan.update', $ruangan) }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Ruangan --}}
                <div class="md:col-span-2">
                    <label for="nama_ruangan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="nama_ruangan"
                           name="nama_ruangan"
                           value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                           placeholder="cth. Ruang Poli Umum, Ruang Spesialis Jantung"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('nama_ruangan') border-red-400 bg-red-50 @enderror">
                    @error('nama_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Ruangan --}}
                <div>
                    <label for="kode_ruangan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kode Ruangan
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text"
                           id="kode_ruangan"
                           name="kode_ruangan"
                           value="{{ old('kode_ruangan', $ruangan->kode_ruangan) }}"
                           placeholder="cth. R-001, POLI-A"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('kode_ruangan') border-red-400 bg-red-50 @enderror">
                    @error('kode_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-400 text-xs mt-1">Kode unik untuk identifikasi cepat ruangan</p>
                </div>

                {{-- Spacer --}}
                <div class="hidden md:block"></div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              placeholder="Tuliskan deskripsi atau keterangan tambahan tentang ruangan ini..."
                              class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 resize-none @error('deskripsi') border-red-400 bg-red-50 @enderror">{{ old('deskripsi', $ruangan->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.ruangan.index') }}"
                   class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-150 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

