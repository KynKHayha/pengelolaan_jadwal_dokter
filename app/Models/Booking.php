<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'jadwal_id',
        'keluhan',
        'tanggal_booking',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            default      => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'confirmed' => 'Dikonfirmasi',
            'cancelled'  => 'Dibatalkan',
            default      => 'Menunggu',
        };
    }
}
