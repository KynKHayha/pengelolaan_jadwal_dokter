<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'dokter_id',
        'ruangan_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota',
        'harga',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'harga'     => 'decimal:2',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
