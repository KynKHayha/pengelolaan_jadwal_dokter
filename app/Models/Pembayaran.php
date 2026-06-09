<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'booking_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_transfer',
        'status_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status_pembayaran) {
            'valid'   => 'bg-green-100 text-green-800',
            'invalid' => 'bg-red-100 text-red-800',
            default   => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status_pembayaran) {
            'valid'   => 'Valid',
            'invalid' => 'Tidak Valid',
            default   => 'Menunggu Verifikasi',
        };
    }
}
