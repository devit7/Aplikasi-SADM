<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function loginOrangTua(Request $request)
    {
        // Validasi input
        $request->validate([
            'nisn' => 'required|string',
            'nis' => 'required|string',
        ]);

        // Ambil data dari request
        $nisn = $request->input('nisn');
        $nis = $request->input('nis');

        // Cari siswa berdasarkan NISN dan NIS
        $siswa = Siswa::where('nisn', $nisn)
                      ->where('nis', $nis)
                      ->first();

        // Jika siswa ditemukan, simpan data ke session dan redirect ke dashboard
        if ($siswa) {
            // Simpan data siswa ke session
            Session::put('siswa', $siswa);

            return redirect('/ortu'); // Sesuaikan dengan route dashboard ortu
        }

        // Jika siswa tidak ditemukan, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'nisn' => 'NISN atau NIS yang Anda masukkan salah.',
        ])->withInput();
    }

    // Logout ortu
    public function logoutOrtu()
    {
        // Hapus session siswa
        Session::forget('siswa');

        return redirect('/ortu/login'); // Redirect ke halaman login
    }
}
