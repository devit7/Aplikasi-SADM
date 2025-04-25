<?php

namespace App\Http\Middleware; // Pastikan namespace ini benar

use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class stafAkses
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('staff')) {
            return redirect('staf.login-staf')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}