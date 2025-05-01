<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\StaffAcces;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $tahun_ajaran = Kelas::distinct()->pluck('tahun_ajaran');
        $semester = Matapelajaran::distinct()->pluck('semester');

        $staff_acces = StaffAcces::where('staff_id', session('staff')->id)->first();
        $kelas = Kelas::with('matapelajaran')->withCount('siswa')->where('id', $staff_acces->kelas_id)->get();

        return view('staf.dashboard-staff', compact('kelas', 'tahun_ajaran', 'semester', 'staff_acces'));
    }

    public function show($id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        $staff_acces = StaffAcces::where('staff_id', session('staff')->id)->first();

        return view('staf.list-siswa', compact('kelas', 'staff_acces'));
    }
}
