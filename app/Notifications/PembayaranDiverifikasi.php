<?php

namespace App\Notifications;

use App\Models\Pembayaran;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiverifikasi extends Notification
{
    use Queueable;

    public function __construct(public Pembayaran $pembayaran) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $isValid = $this->pembayaran->status_pembayaran === 'valid';
        return [
            'type'           => 'pembayaran_diverifikasi',
            'message'        => $isValid
                ? '✅ Pembayaran Anda telah diverifikasi! Hadir tepat waktu sesuai jadwal.'
                : '❌ Bukti pembayaran Anda ditolak. Silakan cek catatan dan upload ulang.',
            'status'         => $this->pembayaran->status_pembayaran,
            'booking_id'     => $this->pembayaran->booking_id,
            'url'            => route('user.booking.konfirmasi', $this->pembayaran->booking_id),
        ];
    }
}
