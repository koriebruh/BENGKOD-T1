<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDokter
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'dokter') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Anda tidak memiliki akses');
    }
}
