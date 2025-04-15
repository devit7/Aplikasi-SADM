<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
class OrtuAkses
{
    /**
     * Handle an incoming request.
     * 
     * 
     * * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah session siswa tersedia
        if (!Session::has('siswa')) {
            // Jika belum login, redirect ke halaman login ortu
            return redirect('/ortu/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
