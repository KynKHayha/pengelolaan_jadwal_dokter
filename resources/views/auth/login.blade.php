<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login "” DocPlanner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-blue-700 flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-9 h-9 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">DocPlanner</h1>
            <p class="text-blue-200 text-sm mt-1">Sistem Penjadwalan Dokter Online</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Selamat Datang</h2>
            <p class="text-sm text-slate-500 mb-6">Masuk ke akun DocPlanner Anda</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           placeholder="email@contoh.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="text-sm font-semibold text-slate-700">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Lupa kata sandi?</a>
                        @endif
                    </div>
                    <input type="password" id="password" name="password" required
                           class="w-full border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200' }} rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                           placeholder=""¢"¢"¢"¢"¢"¢"¢"¢">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember_me" name="remember"
                           class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <label for="remember_me" class="text-sm text-slate-600">Ingat saya</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-all shadow-md hover:shadow-lg text-sm mt-2">
                    Masuk
                </button>
            </form>

            @if (Route::has('register'))
                <p class="text-center text-sm text-slate-500 mt-5">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Daftar sekarang</a>
                </p>
            @endif
        </div>

        <p class="text-center text-blue-300 text-xs mt-6">&copy; {{ date('Y') }} DocPlanner. All rights reserved.</p>
    </div>
</body>
</html>

