<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') "” DocPlanner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 10px; }
        .fade-in { animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .nav-active { background: rgba(255,255,255,0.15); border-bottom: 2px solid #fff; }
        .card-hover { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(37,99,235,0.12); }
        .badge { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen antialiased">

    <!-- ===== NAVBAR ===== -->
    <header class="bg-blue-700 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-bold text-lg leading-none">DocPlanner</span>
                        <span class="block text-blue-200 text-xs">Jadwalkan dengan mudah</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('user.dashboard') }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:bg-white/10 transition-all
                              {{ request()->routeIs('user.dashboard') ? 'nav-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('user.cari-jadwal') }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:bg-white/10 transition-all
                              {{ request()->routeIs('user.cari-jadwal') ? 'nav-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Cari Jadwal
                    </a>
                    <a href="{{ route('user.booking.riwayat') }}"
                       class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:bg-white/10 transition-all
                              {{ request()->routeIs('user.booking.riwayat') ? 'nav-active' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Riwayat
                    </a>
                </nav>

                <!-- User Dropdown -->
                {{-- Bell Notifikasi --}}
                @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                <a href="{{ route('user.notifikasi.index') }}" class="relative p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white rounded-xl px-3 py-2 text-sm font-medium transition-all">
                            <div class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs text-slate-400">Masuk sebagai</p>
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger -->
                <button id="hamburger-btn" class="md:hidden p-2 text-white rounded-lg hover:bg-white/10">
                    <svg id="hamburger-icon" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-blue-600">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-white rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-white/15' : 'hover:bg-white/10' }}">
                    Dashboard
                </a>
                <a href="{{ route('user.cari-jadwal') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-white rounded-lg {{ request()->routeIs('user.cari-jadwal') ? 'bg-white/15' : 'hover:bg-white/10' }}">
                    Cari Jadwal
                </a>
                <a href="{{ route('user.booking.riwayat') }}" class="flex items-center gap-2 px-3 py-2.5 text-sm font-medium text-white rounded-lg {{ request()->routeIs('user.booking.riwayat') ? 'bg-white/15' : 'hover:bg-white/10' }}">
                    Riwayat Booking
                </a>
            </div>
            <div class="px-4 py-3 border-t border-blue-600">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-blue-200">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 text-sm text-white bg-red-500/60 rounded-lg hover:bg-red-500/80 transition-all">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- ===== CONTENT ===== -->
    <main class="fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5">
            @if(session('success'))
                <div class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-sm mb-5" id="flash-success">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm mb-5" id="flash-error">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-12 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-slate-700 text-sm">DocPlanner</span>
                </div>
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} DocPlanner. Sistem Penjadwalan Dokter Online.</p>
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('hamburger-btn');
        const menu = document.getElementById('mobile-menu');
        const hIcon = document.getElementById('hamburger-icon');
        const cIcon = document.getElementById('close-icon');
        if (btn) btn.addEventListener('click', () => {
            const isOpen = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden', isOpen);
            hIcon.classList.toggle('hidden', !isOpen);
            cIcon.classList.toggle('hidden', isOpen);
        });
        // auto dismiss
        ['flash-success','flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => { el.style.opacity='0'; el.style.transition='opacity 0.4s'; setTimeout(()=>el.remove(),400); }, 4500);
        });
    </script>
    @stack('scripts')
</body>
</html>

