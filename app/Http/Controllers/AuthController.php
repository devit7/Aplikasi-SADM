<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //walas
    public function loginWalas(Request $request)
    {
        $credentials = $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['nip' => $credentials['nip'], 'password' => $credentials['password']])) {
            return redirect()->route('walas.index'); // Ganti dengan dashboard yang benar
        }

        return back()->withErrors(['nip' => 'NIP atau password salah'])->withInput();
    }

    public function logoutWalas()
    {
        Auth::logout();
        return redirect()->route('loginWalas');
    }

    public function loginOrtu(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required',
            'nis' => 'required'
        ]);

        if (Auth::attempt(['nisn' => $credentials['nisn'], 'nis' => $credentials['nis']])) {
            return redirect()->route('ortu.index'); 
        }

        return back()->withErrors(['nisn' => 'NIS atau NISN Salah'])->withInput();
    }

    public function logoutOrtu()
    {
        Auth::logout();
        return redirect()->route('loginOrtu');
    }

}
