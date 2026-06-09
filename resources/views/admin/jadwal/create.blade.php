@extends('layouts.admin')

@section('page-title', 'Tambah Jadwal')
@section('page-subtitle', 'Formulir penambahan jadwal praktik baru')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.jadwal.index') }}" class="hover:text-blue-600 transition-colors">Kelola Jadwal</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-blue-600 font-medium">Tambah Jadwal</span>
    </nav>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Tambah Jadwal Praktik Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah untuk menambahkan jadwal praktik dokter</p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Dokter --}}
                <div>
                    <label for="dokter_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Dokter <span class="text-red-500">*</span>
                    </label>
                    <select id="dokter_id"
                            name="dokter_id"
                            class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 bg-white @error('dokter_id') border-red-400 bg-red-50 @enderror">
                        <option value="">"” Pilih Dokter "”</option>
                        @foreach($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                            {{ $dokter->nama_dokter }} "” {{ $dokter->spesialisasi }}
                        </option>
                        @endforeach
                    </select>
                    @error('dokter_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ruangan --}}
                <div>
                    <label for="ruangan_id" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Ruangan <span class="text-red-500">*</span>
                    </label>
                    <select id="ruangan_id"
                            name="ruangan_id"
                            class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 bg-white @error('ruangan_id') border-red-400 bg-red-50 @enderror">
                        <option value="">"” Pilih Ruangan "”</option>
                        @foreach($ruangans as $ruangan)
                        <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                            {{ $ruangan->nama_ruangan }}{{ $ruangan->kode_ruangan ? ' (' . $ruangan->kode_ruangan . ')' : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('ruangan_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hari --}}
                <div>
                    <label for="hari" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Hari Praktik <span class="text-red-500">*</span>
                    </label>
                    <select id="hari"
                            name="hari"
                            class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 bg-white @error('hari') border-red-400 bg-red-50 @enderror">
                        <option value="">"” Pilih Hari "”</option>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                        <option value="{{ $hari }}" {{ old('hari') === $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kuota --}}
                <div>
                    <label for="kuota" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kuota Pasien <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="kuota"
                           name="kuota"
                           value="{{ old('kuota', 10) }}"
                           min="1"
                           max="100"
                           placeholder="10"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('kuota') border-red-400 bg-red-50 @enderror">
                    @error('kuota')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-400 text-xs mt-1">Jumlah maksimal pasien yang dapat booking per jadwal</p>
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label for="jam_mulai" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Jam Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="time"
                           id="jam_mulai"
                           name="jam_mulai"
                           value="{{ old('jam_mulai') }}"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('jam_mulai') border-red-400 bg-red-50 @enderror">
                    @error('jam_mulai')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label for="jam_selesai" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Jam Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="time"
                           id="jam_selesai"
                           name="jam_selesai"
                           value="{{ old('jam_selesai') }}"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('jam_selesai') border-red-400 bg-red-50 @enderror">
                    @error('jam_selesai')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Biaya Konsultasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-sm font-semibold text-slate-500">Rp</span>
                        </div>
                        <input type="number"
                               id="harga"
                               name="harga"
                               value="{{ old('harga', 0) }}"
                               min="0"
                               step="5000"
                               placeholder="0"
                               class="w-full border border-slate-200 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('harga') border-red-400 bg-red-50 @enderror">
                    </div>
                    @error('harga')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-slate-400 text-xs mt-1">Isi 0 untuk gratis</p>
                </div>

                {{-- Status Aktif --}}
                <div class="md:col-span-2">
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer">
                        </div>
                        <div>
                            <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">
                                Jadwal Aktif
                            </label>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Jika dicentang, pasien dapat melakukan booking pada jadwal ini. Hilangkan centang untuk menonaktifkan jadwal sementara.
                            </p>
                        </div>
                    </div>
                </div>

            </div>


            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.jadwal.index') }}"
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
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

