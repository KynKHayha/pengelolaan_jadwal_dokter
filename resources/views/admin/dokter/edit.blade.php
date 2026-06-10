@extends('layouts.admin')

@section('page-title', 'Edit Data Dokter')
@section('page-subtitle', 'Perbarui informasi dokter yang sudah terdaftar')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.dokter.index') }}" class="hover:text-blue-600 transition-colors">Kelola Dokter</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-blue-600 font-medium">Edit Dokter</span>
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
                    <h3 class="text-base font-bold text-slate-800">Edit Data Dokter</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Memperbarui data: <span class="font-semibold text-amber-600">{{ $dokter->nama_dokter }}</span></p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.dokter.update', $dokter) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Dokter --}}
                <div class="md:col-span-2">
                    <label for="nama_dokter" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Dokter <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="nama_dokter"
                           name="nama_dokter"
                           value="{{ old('nama_dokter', $dokter->nama_dokter) }}"
                           placeholder="Masukkan nama lengkap dokter"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('nama_dokter') border-red-400 bg-red-50 @enderror">
                    @error('nama_dokter')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Spesialisasi --}}
                <div>
                    <label for="spesialisasi" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Spesialisasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="spesialisasi"
                           name="spesialisasi"
                           value="{{ old('spesialisasi', $dokter->spesialisasi) }}"
                           placeholder="cth. Dokter Umum, Spesialis Jantung"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('spesialisasi') border-red-400 bg-red-50 @enderror">
                    @error('spesialisasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. Telepon --}}
                <div>
                    <label for="no_telepon" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        No. Telepon
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text"
                           id="no_telepon"
                           name="no_telepon"
                           value="{{ old('no_telepon', $dokter->no_telepon) }}"
                           placeholder="cth. 08123456789"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 @error('no_telepon') border-red-400 bg-red-50 @enderror">
                    @error('no_telepon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="md:col-span-2">
                    <label for="bio" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Bio / Keterangan
                        <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="bio"
                              name="bio"
                              rows="3"
                              placeholder="Tuliskan bio singkat atau keterangan tambahan tentang dokter..."
                              class="w-full border border-slate-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-150 resize-none @error('bio') border-red-400 bg-red-50 @enderror">{{ old('bio', $dokter->bio) }}</textarea>
                    @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Foto Dokter
                        <span class="text-slate-400 font-normal">(opsional – kosongkan jika tidak ingin mengubah)</span>
                    </label>

                    {{-- Foto Saat Ini --}}
                    @if($dokter->foto)
                    <div class="flex items-center gap-4 mb-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <img src="{{ asset('storage/' . $dokter->foto) }}"
                             alt="{{ $dokter->nama_dokter }}"
                             class="w-16 h-16 rounded-full object-cover ring-2 ring-blue-200">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Foto saat ini</p>
                            <p class="text-xs text-slate-400 mt-0.5">Upload foto baru di bawah untuk mengganti foto ini</p>
                        </div>
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 hover:border-blue-400 transition-colors duration-150 @error('foto') border-red-400 @enderror">
                        <label for="foto" class="flex flex-col items-center gap-2 cursor-pointer">
                            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <span class="text-sm font-medium text-blue-600">Klik untuk pilih foto baru</span>
                                <p class="text-xs text-slate-400 mt-0.5">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                    </div>
                    {{-- Preview Baru --}}
                    <div id="preview-container" class="hidden mt-3">
                        <img id="foto-preview" src="" alt="Preview" class="w-20 h-20 rounded-full object-cover ring-2 ring-blue-200">
                        <p class="text-xs text-slate-400 mt-1">Preview foto baru</p>
                    </div>
                    @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.dokter.index') }}"
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

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('foto-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

