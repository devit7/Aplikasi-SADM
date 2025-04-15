<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class ortuAkses
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Get the authenticated user
        $user = Auth::user();
        
        // Check if the user is associated with a student record
        $siswa = Siswa::where('user_id', $user->id)->first();
        
        if (!$siswa) {
            // If not a student, redirect to unauthorized page or home
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // User is authenticated and is a student, proceed with the request
        return $next($request);
    }
}
