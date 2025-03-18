<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class WalasController extends Controller
{
    //
    public function index(){
        $tahun_ajaran = Kelas::distinct()->pluck('tahun_ajaran');
        $kelas = Kelas::with('matapelajaran')->withCount('siswa')->get();

        return view('walas.dashboard-walas', compact('kelas', 'tahun_ajaran'));
    }
    public function showSiswa($id){
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('walas.list-siswa', compact('kelas'));
    }
}
