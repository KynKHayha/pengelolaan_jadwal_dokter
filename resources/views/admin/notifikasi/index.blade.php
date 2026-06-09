@extends('layouts.admin')
@section('page-title', 'Notifikasi')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Notifikasi</h1>
            <p class="text-sm text-slate-500 mt-1">Notifikasi pembayaran dari pengguna</p>
        </div>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <form action="{{ route('admin.notifikasi.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    {{-- Notification List --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        @forelse($notifications as $notif)
        <div class="flex gap-4 px-5 py-4 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors {{ $notif->read_at ? '' : 'bg-blue-50/30' }}">

            {{-- Icon --}}
            <div class="flex-shrink-0 mt-0.5">
                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm text-slate-800 font-medium leading-relaxed">
                    {{ $notif->data['message'] ?? 'Notifikasi baru' }}
                </p>
                <div class="flex items-center gap-3 mt-1.5">
                    <p class="text-xs text-slate-400">{{ $notif->created_at->diffForHumans() }}</p>
                    @if(!$notif->read_at)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">Baru</span>
                    @endif
                </div>
                @if(isset($notif->data['url']))
                <a href="{{ $notif->data['url'] }}" class="inline-flex items-center gap-1 mt-2 text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                    Verifikasi Sekarang
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="py-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-slate-500 font-semibold text-sm">Belum ada notifikasi</p>
            <p class="text-slate-400 text-xs mt-1">Notifikasi dari pengguna akan tampil di sini</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div>
        {{ $notifications->links() }}
    </div>
    @endif

</div>
@endsection

