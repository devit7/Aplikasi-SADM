<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrtuAuthController extends Controller
{
    //
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('siswa')) {
            return redirect('/ortu');
        }

        return view('ortu.login-ortu'); // Sesuaikan dengan nama view Anda
    }
    public function loginOrtu(Request $request)
    {
        //dd('Login Ortu');
        // Validasi input dengan rules yang sama seperti di Filament
        $request->validate([
            'nisn' => [
                'required',
                'string',
                'digits:10',
                'numeric'
            ],
            'nis' => [
                'required',
                'string',
                'digits:5',
                'numeric'
            ],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus terdiri dari 10 digit.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.digits' => 'NIS harus terdiri dari 5 digit.',
            'nis.numeric' => 'NIS harus berupa angka.',
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
            'login' => 'NISN atau NIS yang Anda masukkan tidak valid atau tidak terdaftar.',
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
