<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Matapelajaran;
use Illuminate\Http\Request;

class WalasController extends Controller
{
    //
    public function index()
    {
        $tahun_ajaran = Kelas::distinct()->pluck('tahun_ajaran');
        $semester = Matapelajaran::distinct()->pluck('semester');
        $kelas = Kelas::with('matapelajaran')->withCount('siswa')->get();

        return view('walas.dashboard-walas', compact('kelas', 'tahun_ajaran', 'semester'));
    }
    public function show($id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('walas.list-siswa', compact('kelas'));
    }
}
