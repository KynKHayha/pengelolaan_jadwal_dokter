<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USERS ===
        $admin = User::create([
            'name'     => 'Muhammad Rijal Alfatori',
            'email'    => 'admin@docplanner.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        // Backup admin dengan email lama (kalau masih inget email lama)
        User::create([
            'name'     => 'Admin DocPlanner',
            'email'    => 'admin@dokterjanji.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        $user1 = User::create([
            'name'     => 'Dzaki Pratama',
            'email'    => 'dzaki@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        $user2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        $user3 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        // === DOKTER ===
        $dokter1 = Dokter::create([
            'nama_dokter'  => 'Dr. Ahmad Fauzi, Sp.JP',
            'spesialisasi' => 'Jantung dan Pembuluh Darah',
            'no_telepon'   => '081234567890',
            'bio'          => 'Dokter spesialis jantung berpengalaman lebih dari 15 tahun di RSUD Kota.',
        ]);

        $dokter2 = Dokter::create([
            'nama_dokter'  => 'Dr. Ratna Dewi, Sp.A',
            'spesialisasi' => 'Anak',
            'no_telepon'   => '082345678901',
            'bio'          => 'Dokter anak yang ramah dan berpengalaman menangani pasien usia 0-18 tahun.',
        ]);

        $dokter3 = Dokter::create([
            'nama_dokter'  => 'Dr. Budi Santoso, Sp.PD',
            'spesialisasi' => 'Penyakit Dalam',
            'no_telepon'   => '083456789012',
            'bio'          => 'Spesialis penyakit dalam dengan fokus pada diabetes dan hipertensi.',
        ]);

        $dokter4 = Dokter::create([
            'nama_dokter'  => 'Dr. Eka Putri, Sp.OG',
            'spesialisasi' => 'Kandungan & Kebidanan',
            'no_telepon'   => '084567890123',
            'bio'          => 'Dokter spesialis kandungan berpengalaman 10 tahun.',
        ]);

        $dokter5 = Dokter::create([
            'nama_dokter'  => 'Dr. Hendra Wijaya, Sp.N',
            'spesialisasi' => 'Neurologi',
            'no_telepon'   => '085678901234',
            'bio'          => 'Spesialis saraf dengan keahlian di bidang migrain dan stroke.',
        ]);

        // === RUANGAN ===
        $ruangan1 = Ruangan::create([
            'nama_ruangan' => 'Ruang Jantung A',
            'kode_ruangan' => 'RJA-01',
            'deskripsi'    => 'Ruang pemeriksaan jantung lantai 2',
        ]);

        $ruangan2 = Ruangan::create([
            'nama_ruangan' => 'Ruang Anak B',
            'kode_ruangan' => 'RAB-01',
            'deskripsi'    => 'Ruang periksa anak lantai 1',
        ]);

        $ruangan3 = Ruangan::create([
            'nama_ruangan' => 'Ruang Penyakit Dalam',
            'kode_ruangan' => 'RPD-01',
            'deskripsi'    => 'Ruang pemeriksaan penyakit dalam lantai 3',
        ]);

        $ruangan4 = Ruangan::create([
            'nama_ruangan' => 'Ruang Kandungan',
            'kode_ruangan' => 'RKB-01',
            'deskripsi'    => 'Ruang pemeriksaan kandungan dan kebidanan',
        ]);

        $ruangan5 = Ruangan::create([
            'nama_ruangan' => 'Ruang Neurologi',
            'kode_ruangan' => 'RNE-01',
            'deskripsi'    => 'Ruang pemeriksaan saraf lantai 2',
        ]);

        // === JADWAL (dengan harga) ===
        $jadwal1 = Jadwal::create([
            'dokter_id'   => $dokter1->id,
            'ruangan_id'  => $ruangan1->id,
            'hari'        => 'Senin',
            'jam_mulai'   => '08:00',
            'jam_selesai' => '12:00',
            'kuota'       => 10,
            'harga'       => 150000,
            'is_active'   => true,
        ]);

        $jadwal2 = Jadwal::create([
            'dokter_id'   => $dokter1->id,
            'ruangan_id'  => $ruangan1->id,
            'hari'        => 'Rabu',
            'jam_mulai'   => '13:00',
            'jam_selesai' => '17:00',
            'kuota'       => 10,
            'harga'       => 150000,
            'is_active'   => true,
        ]);

        $jadwal3 = Jadwal::create([
            'dokter_id'   => $dokter2->id,
            'ruangan_id'  => $ruangan2->id,
            'hari'        => 'Selasa',
            'jam_mulai'   => '09:00',
            'jam_selesai' => '13:00',
            'kuota'       => 15,
            'harga'       => 120000,
            'is_active'   => true,
        ]);

        $jadwal4 = Jadwal::create([
            'dokter_id'   => $dokter2->id,
            'ruangan_id'  => $ruangan2->id,
            'hari'        => 'Kamis',
            'jam_mulai'   => '14:00',
            'jam_selesai' => '17:00',
            'kuota'       => 15,
            'harga'       => 120000,
            'is_active'   => true,
        ]);

        $jadwal5 = Jadwal::create([
            'dokter_id'   => $dokter3->id,
            'ruangan_id'  => $ruangan3->id,
            'hari'        => 'Kamis',
            'jam_mulai'   => '08:00',
            'jam_selesai' => '11:00',
            'kuota'       => 12,
            'harga'       => 100000,
            'is_active'   => true,
        ]);

        $jadwal6 = Jadwal::create([
            'dokter_id'   => $dokter4->id,
            'ruangan_id'  => $ruangan4->id,
            'hari'        => 'Jumat',
            'jam_mulai'   => '10:00',
            'jam_selesai' => '14:00',
            'kuota'       => 8,
            'harga'       => 200000,
            'is_active'   => true,
        ]);

        $jadwal7 = Jadwal::create([
            'dokter_id'   => $dokter5->id,
            'ruangan_id'  => $ruangan5->id,
            'hari'        => 'Sabtu',
            'jam_mulai'   => '08:00',
            'jam_selesai' => '12:00',
            'kuota'       => 10,
            'harga'       => 175000,
            'is_active'   => true,
        ]);

        // === BOOKING SAMPLES ===
        $booking1 = Booking::create([
            'user_id'         => $user1->id,
            'jadwal_id'       => $jadwal1->id,
            'keluhan'         => 'Dada terasa sakit dan sesak napas',
            'tanggal_booking' => now()->next('Monday')->format('Y-m-d'),
            'status'          => 'confirmed',
        ]);

        $booking2 = Booking::create([
            'user_id'         => $user1->id,
            'jadwal_id'       => $jadwal3->id,
            'keluhan'         => 'Anak demam sudah 3 hari tidak turun',
            'tanggal_booking' => now()->next('Tuesday')->format('Y-m-d'),
            'status'          => 'pending',
        ]);

        $booking3 = Booking::create([
            'user_id'         => $user2->id,
            'jadwal_id'       => $jadwal6->id,
            'keluhan'         => 'Kontrol rutin kehamilan trimester kedua',
            'tanggal_booking' => now()->next('Friday')->format('Y-m-d'),
            'status'          => 'pending',
        ]);

        $booking4 = Booking::create([
            'user_id'         => $user3->id,
            'jadwal_id'       => $jadwal7->id,
            'keluhan'         => 'Sering sakit kepala dan pusing',
            'tanggal_booking' => now()->next('Saturday')->format('Y-m-d'),
            'status'          => 'pending',
        ]);

        // === PEMBAYARAN SAMPLES ===
        Pembayaran::create([
            'booking_id'        => $booking1->id,
            'jumlah'            => 150000,
            'metode_pembayaran' => 'Transfer Bank',
            'status_pembayaran' => 'valid',
        ]);

        Pembayaran::create([
            'booking_id'        => $booking2->id,
            'jumlah'            => 120000,
            'metode_pembayaran' => 'DANA',
            'status_pembayaran' => 'pending',
        ]);

        Pembayaran::create([
            'booking_id'        => $booking3->id,
            'jumlah'            => 200000,
            'metode_pembayaran' => 'GoPay',
            'status_pembayaran' => 'pending',
        ]);
    }
}
