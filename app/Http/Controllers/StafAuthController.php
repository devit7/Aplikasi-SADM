<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StafAuthController extends Controller
{
    //
    public function loginStaf(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);
        // Ambil data dari request
        $nip = $request->input('nip');
        $password = $request->input('password');

        // Cari siswa berdasarkan NIP dan Password
        $staf = Staff::where('nip', $nip)->first();
        // dd($staf);
        if ($staf && Hash::check($password, $staf->password)) {
            // Password cocok
            Session::put('staff', $staf);
            return redirect('/staff');
        }
        return back()->withErrors([
            'nip' => 'NIP atau Password yang Anda masukkan salah.',
        ])->withInput();
    }

    public function logoutStaf()
    {
        Auth::logout();
        Session::forget('staff'); // Hapus sesi 'staff'
        return redirect()->route('staf.login-staf');
    }

    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Session::has('staff')) {
            return redirect('/staff');
        }

        return view('staf.login-staf'); 
    }
}
