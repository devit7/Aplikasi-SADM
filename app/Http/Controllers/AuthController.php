<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
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

}
