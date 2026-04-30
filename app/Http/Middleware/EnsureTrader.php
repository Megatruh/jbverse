<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTrader
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role === 'pengusaha'){
            if (Auth::user()->status === 'suspended' && 
                !$request->is('pengusaha/dashboard') &&
                !$request->is('pengusaha/request-reactivate'))
                {
                return redirect()
                ->route('pengusaha.dashboard')
                ->with(
                    'error', 
                    'Akun anda sedang dibekukan. Silahkan hubungi admin untuk aktivasi kembali'
                );
            }
            return $next($request);
        }
        // Jika bukan pengusaha, blokir akses
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
