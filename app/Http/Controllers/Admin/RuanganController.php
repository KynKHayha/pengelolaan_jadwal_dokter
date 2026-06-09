<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::withCount('jadwals')->latest()->paginate(15);
        return view('admin.ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('admin.ruangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan'  => 'required|string|max:255',
            'kode_ruangan'  => 'nullable|string|max:20|unique:ruangans',
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        Ruangan::create($validated);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan!');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validated = $request->validate([
            'nama_ruangan'  => 'required|string|max:255',
            'kode_ruangan'  => 'nullable|string|max:20|unique:ruangans,kode_ruangan,' . $ruangan->id,
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        $ruangan->update($validated);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus!');
    }
}
