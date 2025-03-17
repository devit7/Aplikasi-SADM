<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class WalasController extends Controller
{
    //
    public function index(){
        $kelas = Kelas::with('matapelajaran')->withCount('siswa')->get();
        return view('walas.dashboard-walas',["kelas" => $kelas]);
    }
    public function showSiswa($id){
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('walas.list-siswa', compact('kelas'));
    }
}
