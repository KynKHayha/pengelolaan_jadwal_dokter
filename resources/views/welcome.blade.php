<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocPlanner – Jadwalkan Dokter Online</title>
    <meta name="description" content="Platform penjadwalan dokter online terpercaya. Buat janji dengan dokter pilihan Anda dengan mudah dan cepat.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%); }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(37,99,235,0.15); }
        .fade-up { animation: fadeUp 0.7s ease forwards; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(25px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.25s; opacity: 0; }
        .delay-3 { animation-delay: 0.4s; opacity: 0; }
    </style>
</head>
<body class="bg-white antialiased">

    <!-- Navbar -->
    <nav class="hero-bg sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-xl">DocPlanner</span>
                </div>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="bg-white/15 hover:bg-white/25 text-white text-sm font-medium px-4 py-2 rounded-lg transition-all">Panel Admin</a>
                            @else
                                <a href="{{ route('user.dashboard') }}" class="bg-white/15 hover:bg-white/25 text-white text-sm font-medium px-4 py-2 rounded-lg transition-all">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-blue-700 hover:bg-blue-50 text-sm font-semibold px-4 py-2 rounded-lg transition-all shadow">Daftar Gratis</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-bg min-h-[85vh] flex items-center relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-800/30 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left -->
                <div class="text-white space-y-6">
                    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur px-4 py-2 rounded-full text-sm font-medium fade-up">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Platform Kesehatan Digital #1
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight fade-up delay-1">
                        Jadwalkan Dokter <span class="text-blue-200">dengan Mudah</span>
                    </h1>
                    <p class="text-blue-100 text-lg leading-relaxed max-w-lg fade-up delay-2">
                        Platform penjadwalan dokter online yang cepat, mudah, dan terpercaya. Pilih dokter, tentukan jadwal, dan konfirmasi booking dalam hitungan menit.
                    </p>
                    <div class="flex flex-wrap gap-4 fade-up delay-3">
                        <a href="{{ route('register') }}"
                           class="bg-white text-blue-700 hover:bg-blue-50 font-bold px-8 py-3.5 rounded-xl text-base transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
                            Mulai Sekarang – Gratis
                        </a>
                        <a href="{{ route('login') }}"
                           class="border-2 border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-3.5 rounded-xl text-base transition-all">
                            Masuk ke Akun
                        </a>
                    </div>
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-white/20 fade-up delay-3">
                        <div>
                            <p class="text-2xl font-black text-white">50+</p>
                            <p class="text-blue-200 text-xs">Dokter Spesialis</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">1K+</p>
                            <p class="text-blue-200 text-xs">Pasien Terdaftar</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">24/7</p>
                            <p class="text-blue-200 text-xs">Layanan Online</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Feature cards -->
                <div class="grid grid-cols-2 gap-4 fade-up delay-2">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 space-y-3">
                        <div class="w-12 h-12 bg-blue-500/40 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold">Cari Dokter</h3>
                        <p class="text-blue-200 text-xs leading-relaxed">Temukan dokter spesialis sesuai kebutuhan</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 space-y-3 mt-6">
                        <div class="w-12 h-12 bg-green-500/40 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold">Buat Janji</h3>
                        <p class="text-blue-200 text-xs leading-relaxed">Pilih jadwal dan buat booking dalam hitungan menit</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 space-y-3">
                        <div class="w-12 h-12 bg-amber-500/40 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold">Bayar Mudah</h3>
                        <p class="text-blue-200 text-xs leading-relaxed">Upload bukti pembayaran secara digital</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 space-y-3 mt-6">
                        <div class="w-12 h-12 bg-purple-500/40 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-bold">Terverifikasi</h3>
                        <p class="text-blue-200 text-xs leading-relaxed">Konfirmasi langsung dari admin sistem</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-slate-800">Cara Menggunakan DocPlanner</h2>
                <p class="text-slate-500 mt-2">Proses booking yang sederhana dalam 4 langkah mudah</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                @foreach([
                    ['1','Daftar Akun','Buat akun gratis dalam 1 menit menggunakan email Anda','blue'],
                    ['2','Cari Jadwal','Temukan dokter dan pilih jadwal yang sesuai','green'],
                    ['3','Booking & Bayar','Konfirmasi booking dan upload bukti pembayaran','amber'],
                    ['4','Datang ke Klinik','Hadir tepat waktu sesuai jadwal yang dipilih','purple'],
                ] as $step)
                <div class="card-hover bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm">
                    <div class="w-14 h-14 bg-{{ $step[3] }}-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-xl font-black text-{{ $step[3] }}-600">{{ $step[0] }}</span>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">{{ $step[1] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $step[2] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="hero-bg py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-black text-white mb-3">Siap Mulai Booking?</h2>
            <p class="text-blue-200 mb-8">Daftar sekarang dan nikmati kemudahan jadwal dokter online</p>
            <a href="{{ route('register') }}"
               class="inline-block bg-white text-blue-700 hover:bg-blue-50 font-bold px-10 py-4 rounded-xl text-base shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1">
                Daftar Sekarang – Gratis
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-900 text-blue-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="font-bold text-white">DocPlanner</span>
            </div>
            <p class="text-xs text-blue-400">&copy; {{ date('Y') }} DocPlanner. Sistem Penjadwalan Dokter Online.</p>
        </div>
    </footer>

</body>
</html>

