<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JadwalController extends Controller
{
    public function index()
    {
        $query = Jadwal::with(['dokter', 'ruangan'])
            ->withCount('bookings')
            ->latest();

        if (request()->filled('hari')) {
            $query->where('hari', request('hari'));
        }

        $jadwals = $query->paginate(15);
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters  = Dokter::orderBy('nama_dokter')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('admin.jadwal.create', compact('dokters', 'ruangans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'ruangan_id'  => 'required|exists:ruangans,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota'       => 'required|integer|min:1|max:100',
            'harga'       => 'required|numeric|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Cek konflik jadwal (dokter yang sama, hari yang sama, jam overlap)
        $this->checkKonflik(
            $validated['dokter_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai']
        );

        Jadwal::create($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal dokter berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $dokters  = Dokter::orderBy('nama_dokter')->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'dokters', 'ruangans'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'dokter_id'   => 'required|exists:dokters,id',
            'ruangan_id'  => 'required|exists:ruangans,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota'       => 'required|integer|min:1|max:100',
            'harga'       => 'required|numeric|min:0',
            'is_active'   => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Cek konflik (kecuali jadwal yang sedang diedit)
        $this->checkKonflik(
            $validated['dokter_id'],
            $validated['hari'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwal->id
        );

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal dokter berhasil diperbarui!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal dokter berhasil dihapus!');
    }

    /**
     * Cek apakah ada konflik jadwal untuk dokter yang sama.
     */
    private function checkKonflik(int $dokterId, string $hari, string $jamMulai, string $jamSelesai, ?int $exceptId = null): void
    {
        $query = Jadwal::where('dokter_id', $dokterId)
            ->where('hari', $hari)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                // Overlap: jadwal existing bertumpang dengan jadwal baru
                $q->where(function ($q2) use ($jamMulai, $jamSelesai) {
                    $q2->where('jam_mulai', '<', $jamSelesai)
                       ->where('jam_selesai', '>', $jamMulai);
                });
            });

        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        $konflik = $query->with('dokter')->first();

        if ($konflik) {
            throw ValidationException::withMessages([
                'jam_mulai' => 'Terjadi konflik jadwal! Dokter ini sudah memiliki jadwal pada hari ' 
                    . $hari . ' pukul ' 
                    . substr($konflik->jam_mulai, 0, 5) . '–' . substr($konflik->jam_selesai, 0, 5) . '.',
            ]);
        }
    }
}
