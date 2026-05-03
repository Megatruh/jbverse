<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role-nya BUKAN 'user'
        if ($request->user()->role !== 'user') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Pengunjung biasa.');
        }

        // 3. Lolos pengecekan, lanjutkan request
        return $next($request);
    }
}
