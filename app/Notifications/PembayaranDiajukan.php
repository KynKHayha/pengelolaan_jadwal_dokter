<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiajukan extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'       => 'pembayaran_diajukan',
            'message'    => 'Bukti pembayaran baru dari ' . $this->booking->user->name . ' perlu diverifikasi.',
            'booking_id' => $this->booking->id,
            'user_name'  => $this->booking->user->name,
            'url'        => route('admin.pembayaran.index'),
        ];
    }
}
