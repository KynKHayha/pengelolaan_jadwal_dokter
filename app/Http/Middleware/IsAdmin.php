<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Jika user sudah login dan role-nya adalah admin, izinkan lewat
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    // Jika bukan admin, tendang kembali ke dashboard pengguna atau halaman utama
    return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
}
}
