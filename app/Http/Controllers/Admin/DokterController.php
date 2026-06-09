<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::withCount('jadwals')->latest()->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokter'  => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_telepon'   => 'nullable|string|max:20',
            'bio'          => 'nullable|string|max:1000',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_dokter', 'public');
        }

        Dokter::create($validated);

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan!');
    }

    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama_dokter'  => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_telepon'   => 'nullable|string|max:20',
            'bio'          => 'nullable|string|max:1000',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_dokter', 'public');
        }

        $dokter->update($validated);

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui!');
    }

    public function destroy(Dokter $dokter)
    {
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }

        $dokter->delete();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus!');
    }
}