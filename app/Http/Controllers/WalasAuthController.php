<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WalasAuthController extends Controller
{
    //
    public function loginWalas(Request $request)
    {
        // Validasi input dengan rules yang sama seperti di UsersResource
        $request->validate([
            'nip' => [
                'required',
                'string',
                'digits:18',
                'numeric'
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'nip.digits' => 'NIP harus 18 karakter.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            'nip' => $request->nip,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            // Pastikan user yang login adalah walikelas
            if (Auth::user()->role === 'walikelas') {
                return redirect()->route('walas.index');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Anda tidak memiliki akses sebagai wali kelas.',
                ])->withInput();
            }
        }

        // Jika login gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'login' => 'NIP atau password yang Anda masukkan tidak valid atau tidak terdaftar.',
        ])->withInput();
    }

    public function logoutWalas()
    {
        Auth::logout();
        return redirect()->route('loginWalas');
    }
}
