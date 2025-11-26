<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WalasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (auth()->user()->level == 'wali_kelas') {
            // Pastikan wali kelas memiliki guru_id dan kelas
            if (!auth()->user()->guru_id || !auth()->user()->guru->kelas) {
                abort(403, 'Anda belum ditugaskan sebagai wali kelas.');
            }
            return $next($request);
        }
        
        abort(403, 'Akses Ditolak.');
    }
}
