<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        Auth::user()->unreadNotifications->markAsRead();
        return view('admin.notifikasi.index', compact('notifications'));
    }

    public function readAll(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
